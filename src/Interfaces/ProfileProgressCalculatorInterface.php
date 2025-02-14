<?php

namespace App\Interfaces;

use App\Entity\Candidate;

interface ProfileProgressCalculatorInterface
{
    public function calculateProgress(Candidate $candidate): int;
}
?>