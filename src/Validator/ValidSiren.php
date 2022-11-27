<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidSiren extends Constraint
{
    public string $message = 'le champ numéro SIREN de l\'entreprise "{{ string }}" doit contenir 9 numéros.';
    public string $mode = 'strict';
}
