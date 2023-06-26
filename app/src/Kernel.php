<?php
/**
 * This is the license block.
 * It can contain licensing information, copyright notices, etc.
 */
namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Class Kernel
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
