<x-adminlte-modal   id="modalCustomHelp" 
                    title="COMO REALIZAR EL ARCHIVO DEL ACERVO BIBLIO-HEMEROGRÁFICO" 
                    size="lg" 
                    theme="teal"
                    icon="fa fa-copy" 
                    v-centered static-backdrop >
    

        <table class="table table-sm table-striped"
                style="font-size:14px;">
            <tr>
                <td align="right"><b>CLAVE DE CLASIFICACIÓN</b></td>
                <td>Clave correspondiente de acuerdo con la clasificación interna que se lleve en la unidad administrativa. </td>
            </tr>
            <tr>
                <td align="right"><b>TITULO DEL DOCUMENTO</b></td>
                <td>Nombre completo que corresponde a la obra biblio-hemerográfica.</td>
            </tr>
            <tr>
                <td align="right"><b>AUTOR</b></td>
                <td>Nombre completo del autor de las obras biblio-hemerográfica..</td>
            </tr>
            <tr>
                <td align="right"><b>EDITORIAL Y FECHA DE PUBLICACIÓN</b></td>
                <td>Nombre de la Editorial y la fecha de publicación.</td>
            </tr>
            <tr>
                <td align="right"><b>COMENTARIOS</b></td>
                <td>Comentarios para precisar el contenido y ubicación del acervo biblio-hemerográfico.</td>
            </tr>
        </table>
    
    <x-slot name="footerSlot">
        <x-adminlte-button  theme="secondary" 
                            label=" CANCELAR ACCIÓN " 
                            data-dismiss="modal" 
                            icon="fa fa-times"
                            class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>