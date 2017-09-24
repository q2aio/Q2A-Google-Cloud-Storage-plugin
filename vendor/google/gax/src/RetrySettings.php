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

/**
 * Holds the parameters for retry and timeout logic with exponential backoff. Actual
 * implementation of the logic is elsewhere.
 *
 * The intent of these settings is to be used with a call to a remote server, which
 * could either fail (and return an error code) or not respond (and cause a timeout).
 * When there is a failure or timeout, the logic should keep trying until the total
 * timeout has passed.
 */
class RetrySettings
{
    private $backoffSettings;
    private $retryableCodes;
    private $inherit;

    /**
     * Create a special instance that indicates that the retry settings should
     * be inherited from defaults.
     *
     * @return RetrySettings
     */
    public static function inherit()
    {
        $retrySettings = new RetrySettings(null, null);
        $retrySettings->inherit = true;
        return $retrySettings;
    }

    /**
     * Construct an instance.
     *
     * @param int[] $retryableCodes Status codes to retry
     * @param BackoffSettings $backoffSettings Backoff settings
     */
    public function __construct($retryableCodes, $backoffSettings)
    {
        $this->retryableCodes = $retryableCodes;
        $this->backoffSettings = $backoffSettings;
        $this->inherit = false;
    }

    /**
     * @return int[] Status codes to retry
     */
    public function getRetryableCodes()
    {
        return $this->retryableCodes;
    }

    /**
     * @return BackoffSettings Backoff settings
     */
    public function getBackoffSettings()
    {
        return $this->backoffSettings;
    }

    /**
     * @return bool Should inherit settings when merging
     */
    public function shouldInherit()
    {
        return $this->inherit;
    }
}
