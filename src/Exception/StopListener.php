<?php

/*
 * This file is part of the Supervisor Event package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Supervisor\Exception;

/**
 * When this exception is thrown, the listener should exit
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class StopListener extends \Exception
{

}
