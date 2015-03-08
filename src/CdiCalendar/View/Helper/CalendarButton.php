<?php
namespace CdiCalendar\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CalendarButton extends AbstractHelper
{
    public function __invoke($class)
    {
    echo "<i class='$class' href=''></i>";
    }
}
