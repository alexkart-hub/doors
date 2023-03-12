let gamer = $('#gamer');
let leftButton = $('.btn-left');
let rightButton = $('.btn-right');

function move(x, y) {
    gamer.animate({
            'top': y,
            'left': x
        }, {
            duration: 1000,
            queue: false,
            specialEasing: {
                height: 'linear',
                width: 'linear'
            }
        }
    )
}

$(window).on({
    click: function (e) {
        move(e.clientX, e.clientY)
    }
});

showGamer(gamer.data('x'));

function showGamer(x)
{
    var left = 0;
    if (x == 1) {
        left = leftButton.offset().left + 100;
    } else {
        left = rightButton.offset().left - 50;
    }
    console.log(left);
    gamer.hide();
    gamer.css({
        'top': 100,
        'left': left,
        'display': 'block',
        'opacity': 1
    });
    gamer.fadeIn(2000);
}
