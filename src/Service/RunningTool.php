<?php 

namespace App\Service;

class RunningTool
{
    public function MaxHeartRate(int $age): int 
    {
        return $fcm = 192 - (0.007 * ($age**2));
    }
}