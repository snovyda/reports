<?php

namespace App\Validator\Constraints;

use App\Services\XMLParser;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class XSDSchemaValidator
 * @package App\Validator\Constraints
 */
class XSDSchemaValidator extends ConstraintValidator
{
    /** @var XMLParser  */
    protected $parser;

    /**
     * XSDSchemaValidator constructor.
     * @param XMLParser $parser
     */
    public function __construct(XMLParser $parser)
    {
        $this->parser = $parser;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof XSDSchema) {
            throw new UnexpectedTypeException($constraint, XSDSchema::class);
        }


        if (null === $value || '' === $value) {
            return;
        }

        $XSDSchema = $this->parser->getXSDSchemaFromFile($value->getPathname());

        if (!$XSDSchema) {
            $this->context->buildViolation($constraint->messageSchemaDoesntExist)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        } elseif (!$this->parser->validateAgainstXSDSchema($value->getPathname(), $XSDSchema)) {
            $this->context->buildViolation($constraint->messageFileIsInvalid)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
