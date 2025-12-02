-- ============================================================
-- SCRIPT DE CORRECCIÓN DE SUELDOS EN PLANTILLA DE PERSONAL
-- ============================================================
-- Este script identifica y corrige valores incorrectos en 
-- la tabla g1claves_plantilla para plazas de jornada semanal
-- ============================================================

-- ============================================================
-- PASO 1: CREAR BACKUP DE SEGURIDAD
-- ============================================================
-- IMPORTANTE: Ejecutar esto ANTES de cualquier corrección
CREATE TABLE IF NOT EXISTS g1claves_plantilla_backup_20250127 AS 
SELECT * FROM g1claves_plantilla;

-- Verificar que el backup se creó correctamente
SELECT COUNT(*) AS total_registros_backup 
FROM g1claves_plantilla_backup_20250127;

-- ============================================================
-- PASO 2: IDENTIFICAR CASOS PROBLEMÁTICOS
-- ============================================================
-- Esta consulta muestra todos los registros que necesitan revisión

SELECT 
    id,
    oclave,
    LEFT(oclave_descripcion, 50) AS descripcion_corta,
    ocm,
    omonto_mensual AS sueldo_actual,
    ohoras_compatibilidad,
    ohoras_servicio,
    ohoras_docencia,
    (COALESCE(ohoras_servicio, 0) + 
     COALESCE(ohoras_docencia, 0) + 
     COALESCE(ohoras_compatibilidad, 0)) AS total_horas,
    otipo,
    otipo_categoria,
    CASE 
        WHEN ocm = 0 AND omonto_mensual < 500 THEN 
            '❌ CRÍTICO: Sueldo muy bajo (< 500)'
        WHEN ocm = 0 AND omonto_mensual < 1000 THEN 
            '⚠️ PROBLEMA: Sueldo bajo (< 1,000)'
        WHEN ocm = 0 AND omonto_mensual < 5000 THEN 
            '⚠️ REVISAR: Sueldo bajo (< 5,000)'
        WHEN ocm = 0 AND omonto_mensual >= 5000 THEN 
            '✅ OK: Sueldo razonable'
        ELSE 
            'ℹ️ No es jornada semanal'
    END AS estado,
    CASE 
        WHEN ocm = 0 AND omonto_mensual < 1000 
             AND (ohoras_servicio > 0 OR ohoras_docencia > 0 OR ohoras_compatibilidad > 0)
        THEN CONCAT(
            'Posiblemente por hora. Si es ', 
            omonto_mensual, 
            ' por hora y ',
            (COALESCE(ohoras_servicio, 0) + COALESCE(ohoras_docencia, 0) + COALESCE(ohoras_compatibilidad, 0)),
            ' horas/semana, debería ser: ',
            ROUND(omonto_mensual * (COALESCE(ohoras_servicio, 0) + COALESCE(ohoras_docencia, 0) + COALESCE(ohoras_compatibilidad, 0)) * 4.33, 2)
        )
        WHEN ocm = 0 AND omonto_mensual < 1000 AND omonto_mensual > 100
        THEN CONCAT(
            'Posiblemente por día. Si es ',
            omonto_mensual,
            ' por día, debería ser: ',
            ROUND(omonto_mensual * 22, 2),
            ' (22 días laborables)'
        )
        ELSE ''
    END AS sugerencia_correccion
FROM g1claves_plantilla
WHERE ocm = 0
ORDER BY omonto_mensual ASC;

-- ============================================================
-- PASO 3: ANÁLISIS DETALLADO POR RANGOS
-- ============================================================

-- Sueldos críticos (< 500)
SELECT 
    COUNT(*) AS total_criticos,
    AVG(omonto_mensual) AS promedio,
    MIN(omonto_mensual) AS minimo,
    MAX(omonto_mensual) AS maximo
FROM g1claves_plantilla
WHERE ocm = 0 AND omonto_mensual < 500;

-- Sueldos problemáticos (500 - 1,000)
SELECT 
    COUNT(*) AS total_problematicos,
    AVG(omonto_mensual) AS promedio,
    MIN(omonto_mensual) AS minimo,
    MAX(omonto_mensual) AS maximo
FROM g1claves_plantilla
WHERE ocm = 0 AND omonto_mensual >= 500 AND omonto_mensual < 1000;

-- Sueldos a revisar (1,000 - 5,000)
SELECT 
    COUNT(*) AS total_revisar,
    AVG(omonto_mensual) AS promedio,
    MIN(omonto_mensual) AS minimo,
    MAX(omonto_mensual) AS maximo
FROM g1claves_plantilla
WHERE ocm = 0 AND omonto_mensual >= 1000 AND omonto_mensual < 5000;

-- Sueldos correctos (>= 5,000)
SELECT 
    COUNT(*) AS total_correctos,
    AVG(omonto_mensual) AS promedio,
    MIN(omonto_mensual) AS minimo,
    MAX(omonto_mensual) AS maximo
FROM g1claves_plantilla
WHERE ocm = 0 AND omonto_mensual >= 5000;

-- ============================================================
-- PASO 4: CORRECCIÓN AUTOMÁTICA (SOLO PARA CASOS ESPECÍFICOS)
-- ============================================================
-- IMPORTANTE: Revisar los resultados antes de ejecutar UPDATE
-- Descomentar solo después de verificar los resultados

-- ============================================================
-- CASO A: Plazas por horas con sueldo por hora (< 1,000)
-- ============================================================
-- Si omonto_mensual está en horas y hay horas registradas,
-- convertir a sueldo mensual completo

/*
UPDATE g1claves_plantilla
SET omonto_mensual = ROUND(
    omonto_mensual * 
    (COALESCE(ohoras_servicio, 0) + 
     COALESCE(ohoras_docencia, 0) + 
     COALESCE(ohoras_compatibilidad, 0)) * 
    4.33,  -- semanas promedio por mes
    2
)
WHERE ocm = 0
  AND omonto_mensual > 0 
  AND omonto_mensual < 1000
  AND (ohoras_servicio > 0 OR ohoras_docencia > 0 OR ohoras_compatibilidad > 0)
  AND (COALESCE(ohoras_servicio, 0) + 
       COALESCE(ohoras_docencia, 0) + 
       COALESCE(ohoras_compatibilidad, 0)) > 0;
*/

-- ============================================================
-- CASO B: Plazas con sueldo por día (100 - 1,000, sin horas)
-- ============================================================
-- Si parece ser sueldo por día, convertir a mensual (22 días)

/*
UPDATE g1claves_plantilla
SET omonto_mensual = ROUND(omonto_mensual * 22, 2)
WHERE ocm = 0
  AND omonto_mensual >= 100 
  AND omonto_mensual < 1000
  AND (ohoras_servicio IS NULL OR ohoras_servicio = 0)
  AND (ohoras_docencia IS NULL OR ohoras_docencia = 0)
  AND (ohoras_compatibilidad IS NULL OR ohoras_compatibilidad = 0);
*/

-- ============================================================
-- PASO 5: VERIFICACIÓN POST-CORRECCIÓN
-- ============================================================
-- Ejecutar después de las correcciones para verificar

SELECT 
    'ANTES' AS periodo,
    COUNT(*) AS total_registros,
    COUNT(CASE WHEN omonto_mensual < 1000 THEN 1 END) AS sueldos_bajos,
    AVG(omonto_mensual) AS promedio
FROM g1claves_plantilla_backup_20250127
WHERE ocm = 0

UNION ALL

SELECT 
    'DESPUÉS' AS periodo,
    COUNT(*) AS total_registros,
    COUNT(CASE WHEN omonto_mensual < 1000 THEN 1 END) AS sueldos_bajos,
    AVG(omonto_mensual) AS promedio
FROM g1claves_plantilla
WHERE ocm = 0;

-- ============================================================
-- PASO 6: COMPARACIÓN DETALLADA (ANTES vs DESPUÉS)
-- ============================================================

SELECT 
    b.id,
    b.oclave,
    LEFT(b.oclave_descripcion, 40) AS descripcion,
    b.omonto_mensual AS sueldo_antes,
    a.omonto_mensual AS sueldo_despues,
    (a.omonto_mensual - b.omonto_mensual) AS diferencia,
    CASE 
        WHEN a.omonto_mensual != b.omonto_mensual THEN '✅ CORREGIDO'
        ELSE 'Sin cambios'
    END AS estado
FROM g1claves_plantilla_backup_20250127 b
INNER JOIN g1claves_plantilla a ON b.id = a.id
WHERE b.ocm = 0
  AND a.omonto_mensual != b.omonto_mensual
ORDER BY diferencia DESC;

-- ============================================================
-- PASO 7: ROLLBACK (SI ES NECESARIO)
-- ============================================================
-- Solo usar si algo sale mal y necesitas revertir

/*
UPDATE g1claves_plantilla a
INNER JOIN g1claves_plantilla_backup_20250127 b ON a.id = b.id
SET a.omonto_mensual = b.omonto_mensual
WHERE a.ocm = 0;
*/

-- ============================================================
-- INSTRUCCIONES DE USO
-- ============================================================
-- 1. Ejecutar PASO 1 (crear backup)
-- 2. Ejecutar PASO 2 (identificar problemas)
-- 3. Revisar los resultados del PASO 2
-- 4. Ejecutar PASO 3 (análisis por rangos)
-- 5. Si los resultados son correctos, descomentar y ejecutar 
--    los UPDATE del PASO 4 (CASO A o CASO B según corresponda)
-- 6. Ejecutar PASO 5 y PASO 6 para verificar las correcciones
-- 7. Si algo sale mal, usar PASO 7 para revertir
-- ============================================================

