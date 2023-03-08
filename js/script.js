let gamer = $('#gamer');
gamer.css({
    'top': 100,
    'left': 100,
    'display': 'block',
    'opacity': 1
});
let n = 0;
let end = 500
gamer.animate({'height': 100, 'width': 100}, {
    duration: 5000,
    queue:false,
    specialEasing: {
        height: 'linear',
        width: 'linear'
    },
    step: function () {
        n++;
        gamer.css({
            'left': 100 + n,
        });
        if (n >= end) {
            gamer.stop();
        }

    }
});