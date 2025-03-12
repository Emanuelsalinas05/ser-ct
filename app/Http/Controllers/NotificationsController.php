<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Alertas;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;

class NotificationsController extends Controller
{
    public function getNotificationsData(Request $request)
    {
        // For the sake of simplicity, assume we have a variable called
        // $notifications with the unread notifications. Each notification
        // have the next properties:
        // icon: An icon for the notification.
        // text: A text for the notification.
        // time: The time since notification was created on the server.
        // At next, we define a hardcoded variable with the explained format,
        // but you can assume this data comes from a database query.
            $alertas = Alertas::where('istatus', 'A')->get();
            /*
            foreach ($alertas as $notification) {
                $notification->texto_alerta;
            }

            return response()->json([
                'notifications' => $notifications
            ]);
            */
                //$alle = $alertas->texto_alerta;

   
            $notifications = [
//            [ 'icon' => 'fas fa-fw fa-envelope','text' => rand(0, 10) . ' new messages', 'time' => rand(0, 10) . ' minutes', ],
//            [ 'icon' => 'fas fa-fw fa-users text-primary', 'text' => rand(0, 10) . ' friend requests', 'time' => rand(0, 60) . ' minutes', ],
//            [ 'icon' => 'fas fa-fw fa-file text-danger', 'text' => rand(0, 10) . ' new reports', 'time' => rand(0, 60) . ' minutes', ],
            
                                [   'icon'  => 'fas fa-info-circle text-success', 
                                    'text'  => 'Asiste a todas tus sesiones', 
                                    'time'  => '',
                                ]
                            ];

            // Now, we create the notification dropdown main content.
            $dropdownHtml = '';
            foreach ($notifications as $key => $not) {
                $icon = "<i class='mr-2 {$not['icon']}'></i>";
                $time = "<span class='float-right text-muted text-sm'>
                           {$not['time']}
                         </span>";
                $dropdownHtml .= "<a href='#' class='dropdown-item'>
                                    {$icon}{$not['text']}{$time}
                                  </a>";
                if ($key < count($notifications) - 1) {
                    $dropdownHtml .= "<div class='dropdown-divider'></div>";
                }
            }
            // Return the new notification data.
            return [
                'label' => count($notifications),
                'label_color' => 'danger',
                'icon_color' => 'dark',
                'dropdown' => $dropdownHtml,
            ];

    }
}
