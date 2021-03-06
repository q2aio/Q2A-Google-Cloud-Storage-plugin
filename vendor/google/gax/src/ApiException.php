<?php
/*
 * Copyright 2016, Google Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\GAX;

use Exception;

/**
 * Represents an exception thrown during an RPC.
 */
class ApiException extends Exception
{
    private $metadata;
    private $basicMessage;

    /**
     * ApiException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     * @param array|null $metadata
     * @param string|null $basicMessage
     */
    public function __construct($message, $code, \Exception $previous = null, $metadata = null, $basicMessage = null)
    {
        parent::__construct($message, $code, $previous);
        $this->metadata = $metadata;
        $this->basicMessage = isset($basicMessage) ? $basicMessage : $message;
    }

    /**
     * @param \stdClass $status
     * @return ApiException
     */
    public static function createFromStdClass($status)
    {
        $basicMessage = $status->details;
        $code = $status->code;
        $metadata = property_exists($status, 'metadata') ? $status->metadata : null;

        $messageData = [
            'message' => $basicMessage,
            'code' => $code,
            'status' => GrpcConstants::getStatusNameFromCode($status->code),
            'details' => Serializer::decodeMetadata($metadata)
        ];

        $message = json_encode($messageData, JSON_PRETTY_PRINT);

        return new ApiException($message, $code, null, $metadata, $basicMessage);
    }

    /**
     * @return null|string
     */
    public function getBasicMessage()
    {
        return $this->basicMessage;
    }

    /**
     * @return mixed[]
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * String representation of ApiException
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": $this->message\n";
    }
}
