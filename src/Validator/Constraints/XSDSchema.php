<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class XSDSchema extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */

    public $messageSchemaDoesntExist = 'Не найдена схема, соответствующая документу';

    public $messageFileIsInvalid = 'Файл не валиден';
}
