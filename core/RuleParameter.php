<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

/**
 * The class RuleParameter represents the different rule parameters which can be validated by the model(s).
 * Currently, it only consists of a few constants.
 */
class RuleParameter
{
    public const PROPERTY = 'property';
    public const MIN = 'min';
    public const MAX = 'max';
    public const MATCH = 'match';
    public const CLASSNAME = 'classname';
    public const LABEL = 'label';
    public const OPTIONS = 'options';
}
