<?php

namespace App\Http\Controllers;

use App\Model\Equipment;
use App\Model\History;
use Illuminate\Http\Request;

class ThingsController extends Controller
{

    // receives the Door id and assigns a new value to open/close and lock/unlock
    public function changeDoorStatus($id, $value){
        // Get the door equipment
        $equipment = Equipment::findOrFail($id);

        // Old status of lock and door
        $open_status_old = explode(",", $equipment->value)[0];
        $lock_status_old = explode(",", $equipment->value)[1];

        // New status of lock and door
        $open_status_new = explode(",", $value)[0];
        $lock_status_new = explode(",", $value)[1];


        // If user tries to change door status
        if($open_status_new != -1){

            // Trying to open a locked door
            if($open_status_new == 1 && $lock_status_old == 1){
                return redirect('/dashboard')->with('error', 'Não pode abrir uma porta que está trancada!');
            }

            // Check if door is already closed/open
            if($open_status_new == $open_status_old){

                return redirect('/dashboard')->with('warning', 'A porta já está '. ($open_status_old == 1 ? 'aberta' : 'fechada' ) .'!');
            }

            // Trying to open a locked door
            if($open_status_new == 0 && $lock_status_old == 1){
                return redirect('/dashboard')->with('error', 'Não pode fechar uma porta que está trancada!');
            }
        }

        // If user tries to change lock status
        if($lock_status_new != -1){

            // Check if door is already locked/unlocked
            if($lock_status_new == $lock_status_old){
                return redirect('/dashboard')->with('warning', 'A porta já está '. ($open_status_old == 1 ? 'trancada' : 'destrancada' ) .'!');
            }

            if($lock_status_new == 1 && $open_status_old == 1){
                return redirect('/dashboard')->with('error', 'Não pode trancar uma porta que está aberta!');
            }

            if($lock_status_new == 0 && $open_status_old == 1){
                return redirect('/dashboard')->with('error', 'Não pode destrancar uma porta que está aberta!');
            }
        }


        // If new status is -1, just maintain the old status
        if($open_status_new == -1){
            $open_status_new = $open_status_old;
        }

        // If new status is -1, just maintain the old status
        if($lock_status_new == -1){
            $lock_status_new = $lock_status_old;
        }

        // Create output string
        $output = $open_status_new . ',' . $lock_status_new;

        // Update values
        $equipment->update(['value' => $output]);

        // Add new entry to history
        $history = new History();
        $history->value = $equipment->value;
        $equipment->histories()->save($history);

        return redirect('/dashboard')->with('success', 'Estado da porta alterado com sucesso!');
    }


    public function changeFanStatus($id, $value){
        // Get equipment related to fan
        $fan = Equipment::findOrFail($id);

        // Just return if data is the same as in database
        if($fan->value == $value){
            return redirect('/dashboard')->with('warning', 'A ventoinha já está '. ($value == 0 ? 'desligada' : ($value == 1 ? 'em baixa velocidade' : 'em alta velocidade')) .'!');
        }

        // Update values
        $fan->update(['value' => $value]);

        // Add new entry to history
        $history = new History();
        $history->value = $fan->value;
        $fan->histories()->save($history);

        return redirect('/dashboard')->with('success', 'Estado da ventoinha alterado com sucesso!');
    }
}
