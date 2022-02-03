<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\SASPortalTesting;

class SasPortalDpaMoveList extends \Google\Model
{
  public $dpaId;
  protected $frequencyRangeType = SasPortalFrequencyRange::class;
  protected $frequencyRangeDataType = '';

  public function setDpaId($dpaId)
  {
    $this->dpaId = $dpaId;
  }
  public function getDpaId()
  {
    return $this->dpaId;
  }
  /**
   * @param SasPortalFrequencyRange
   */
  public function setFrequencyRange(SasPortalFrequencyRange $frequencyRange)
  {
    $this->frequencyRange = $frequencyRange;
  }
  /**
   * @return SasPortalFrequencyRange
   */
  public function getFrequencyRange()
  {
    return $this->frequencyRange;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(SasPortalDpaMoveList::class, 'Google_Service_SASPortalTesting_SasPortalDpaMoveList');
