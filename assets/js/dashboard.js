$(document).ready( function() {
	/*$('.inlinesparkline').sparkline();
	
	var myvalues = [10, 8, 5, 7, 4, 4, 1];
    $('.dynamicsparkline').sparkline(myvalues);
	
	$('.dynamicbar').sparkline(myvalues, {type: 'bar', barColor: 'green'});
	
	$('.inlinebar').sparkline('html', {type: 'bar', barColor: 'red'});*/
	
	$(".sparkline.bar_week").sparkline([5, 6, 7, 2, 0, -4, -2, 4], {
        type: 'bar',
        height: '40',
        barWidth: 5,
        barColor: '#4d6189',
        negBarColor: '#a20051'
    });

    $(".sparkline.line_day").sparkline([5, 6, 7, 9, 9, 5, 4, 6, 6, 4, 6, 7], {
        type: 'line',
        height: '40',
        drawNormalOnTop: false
    });

    $(".sparkline.pie_week").sparkline([1, 1, 2], {
        type: 'pie',
        width: '40',
        height: '40'
    });

    $('.sparkline.stacked_month').sparkline(['0:2', '2:4', '4:2', '4:1'], {
        type: 'bar',
        height: '40',
        barWidth: 10,
        barColor: '#4d6189',
        negBarColor: '#a20051'
    });
	
	/*----------- BEGIN CHART CODE -------------------------*/
    var sin = [], cos = [];
    for (var i = 0; i < 14; i += 0.5) {
        sin.push([i, Math.sin(i)]);
        cos.push([i, Math.cos(i)]);
    }

    var plot = $.plot($("#trigo"),
            [
                {
                    data: sin,
                    label: "sin(x)",
                    points: {
                        fillColor: "#4572A7"
                    },
                    color: '#4572A7'
                },
                {
                    data: cos,
                    label: "cos(x)",
                    points: {
                        fillColor: "#333"
                    },
                    color: '#AA4643'
                }
            ], {
        series: {
            lines: {
                show: true
            },
            points: {
                show: true
            }
        },
        grid: {
            hoverable: true,
            clickable: true
        },
        yaxis: {
            min: -1.2,
            max: 1.2
        }
    });
	
	$(".sortableTable").tablesorter();
	
	//----------- BEGIN FULLCALENDAR CODE -------------------------*/

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,today,next,',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                true // make the event "stick"
                        );
            }
            calendar.fullCalendar('unselect');
        },
        editable: true,
        events: [
            {
                title: 'All Day Event',
                start: new Date(y, m, 1),
                className: 'label label-success'
            },
            {
                title: 'Long Event',
                start: new Date(y, m, d - 5),
                end: new Date(y, m, d - 2),
                className: 'label label-info'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d - 3, 16, 0),
                allDay: false,
                className: 'label label-warning'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d + 4, 16, 0),
                allDay: false,
                className: 'label label-inverse'
            },
            {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false,
                className: 'label label-important'
            },
            {
                title: 'Lunch',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false
            },
            {
                title: 'Birthday Party',
                start: new Date(y, m, d + 1, 19, 0),
                end: new Date(y, m, d + 1, 22, 30),
                allDay: false
            },
            {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'http://google.com/'
            }
        ]
    });
    /*----------- END FULLCALENDAR CODE -------------------------*/
});