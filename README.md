somc-fedev-20150323-ledaco-anders
===========================

== Description ==
A Wordpress plugin that will display all subpages of the page it's placed on. 
A thumbnail will be shown if there is an 'featured image' saved for the page, the image will appear next to the title. 
You can expand and collapse each level by clicking on the page title. 
Click on the header title to sort each level. 
SASS has been used to generate the CCS. 
For sorting a jQuery plugin called tablesorter has been used.

== Tablesorter limitation ==
There is a limitation in the tablesorter plugin that is used for sorting.
The function sorts the highest level in the hierarchy, even if you attempt to sort in a lower.
To fix this you need to build your own JavaScript function or find a plugin that works.

I have found a limiation in the tablesorter plugin when used in the lower levels of the hierachy. 
The function also sorts the highest level when the user click to sort in a lower. 
To fix this I would build my own JavaScript function or find another plugin that works better.