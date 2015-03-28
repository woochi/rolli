<div class='countdown'>
<svg class='countdown' viewBox='0 0 500 500' preserveAspectRatio='xMinYMin meet'>
<?php
  echo sprintf("<circle cx='250' cy='250' r='%u' class='countdown-full'></circle>", $radius);
  echo sprintf("<circle cx='250' cy='250' r='%u' class='countdown-remaining' stroke-dasharray='%f' stroke-dashoffset='0' style='stroke-dashoffset: %fpx;'></circle>", $radius, $dash_array, $dash_offset);
?>
</svg>
<?php
  sprintf("<label class='countdown-amount'>%u <span class='countdown-unit'>päivää</span></label>", $days_remaining);
?>
</div>
