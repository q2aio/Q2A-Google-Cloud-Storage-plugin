<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/privacy/dlp/v2beta1/dlp.proto

namespace Google\Privacy\Dlp\V2beta1;

/**
 * Categorization of results based on how likely they are to represent a match,
 * based on the number of elements they contain which imply a match.
 *
 * Protobuf enum <code>Google\Privacy\Dlp\V2beta1\Likelihood</code>
 */
class Likelihood
{
    /**
     * Default value; information with all likelihoods is included.
     *
     * Generated from protobuf enum <code>LIKELIHOOD_UNSPECIFIED = 0;</code>
     */
    const LIKELIHOOD_UNSPECIFIED = 0;
    /**
     * Few matching elements.
     *
     * Generated from protobuf enum <code>VERY_UNLIKELY = 1;</code>
     */
    const VERY_UNLIKELY = 1;
    /**
     * Generated from protobuf enum <code>UNLIKELY = 2;</code>
     */
    const UNLIKELY = 2;
    /**
     * Some matching elements.
     *
     * Generated from protobuf enum <code>POSSIBLE = 3;</code>
     */
    const POSSIBLE = 3;
    /**
     * Generated from protobuf enum <code>LIKELY = 4;</code>
     */
    const LIKELY = 4;
    /**
     * Many matching elements.
     *
     * Generated from protobuf enum <code>VERY_LIKELY = 5;</code>
     */
    const VERY_LIKELY = 5;
}

