#FHR Search Plugin

This Wordpress plugin allow you to easily add FHR searches to your Wordpress site, the plugin contains
several widgets which allow you to add each of the search form FHR provide and also list all the hotels and car parks available. 

##Shortcodes

###[fhr_search_form]
The above will show the default search form and use all default settings

####[fhr_search_form form=\'airport-parking\' agent=\'fhr\' affwin=\'1111\' airport=\'gatwick\']
The above is a demo off the parameters you can pass in.

####[fhr_search_form] Parameter values
All parameters are optional defaults will be selected from the settings panel, except for form which defaults to parking

+ *form* airport-parking, airport-parking-and-hotels, airport-hotels or airport-lounge
+ *agent* your FHR agent ID
+ *affwin* your Affiliate Window ID<br />
+ *airport* the default airport to select

***

###[fhr_carpark_list]
The above will out put a html list for the default airport set in settings.

####[fhr_carpark_list agent=\'fhr\' affwin=\'1111\' airport=\'gatwick\']
The above is a demo off the parameters you can pass in.

####[fhr_carpark_list] Parameter values
All parameters are optional defaults will be selected from the settings panel, except for form which defaults to parking

+ *agent* your FHR agent ID
+ *affwin* your Affiliate Window ID
+ *airport* the default airport to select

***

###[fhr_hotel_list]
The above will out put a html list for the default airport set in settings.

####[fhr_hotel_list agent=\'fhr\' affwin=\'1111\' airport=\'gatwick\']
The above is a demo off the parameters you can pass in.

####[fhr_hotel_list] Parameter values
All parameters are optional defaults will be selected from the settings panel, except for form which defaults to parking

+ *agent* your FHR agent ID
+ *affwin* your Affiliate Window ID
+ *airport* the default airport to select

***
###[fhr_price_from]
The above will out put a div with the current from price based on the selected airport

####[fhr_price_from agent=\'fhr\' affwin=\'1111\' airport=\'gatwick\']
The above is a demo off the parameters you can pass in.

####[fhr_price_from] Parameter values
All parameters are optional defaults will be selected from the settings panel, except for form which defaults to parking

+ *agent* your FHR agent ID
+ *affwin* your Affiliate Window ID
+ *airport* the default airport to select

***

###[fhr_lorem]
The above will output some lorem text

####[fhr_lorem number=\'5\' type=\'text\']
The above is a demo off the parameters you can pass in.

####[fhr_lorem] Parameter values
All parameters are optional

+ *type* default is text, options are text or list
+ *number* the number of paragraphs or list items to show<

***

###[fhr_lorem_pixel]
The above will output a http://lorempixel.com/ image

####[fhr_lorem_pixel width=\'400\' height=\'400\' type=\'business\']
The above is a demo off the parameters you can pass in.

####[fhr_lorem_pixel] Parameter values
All parameters are optional

+ *type* default is business, options are abstract, city, people, transport, animals, food, nature, nightlife, sports, cats, fashion or technics
+ *width* the width of the image default is 200
+ *height* the height of the image default is 200
