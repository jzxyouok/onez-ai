
    function _html5_star(s) {
        if (navigator.userAgent.indexOf('Firefox') >= 0) {
            //$('#bg').show();
        } else {
            $(s).append('<canvas id=canvas></canvas>');
            var stars = [];
            var count = 0;
            var animate;

            function starMove() {
                "use strict";
                var canvas = document.getElementById('canvas'),
                        ctx = canvas.getContext('2d'),
                        w = canvas.width = $(s).width(),
                        h = canvas.height = $(s).height(),
                        hue = 217,
                        maxStars = 300;
                if($(s).hasClass('fullscreen')){
                  w = canvas.width = $(window).width();
                  h = canvas.height = $(window).height();
                }
                stars = [];
                count = 0;

                var canvas2 = document.createElement('canvas'),
                        ctx2 = canvas2.getContext('2d');

                canvas2.width = 100;
                canvas2.height = 100;
                var half = canvas2.width / 2,
                        gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
                gradient2.addColorStop(0.025, '#CCC');
                gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
                gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
                gradient2.addColorStop(1, 'transparent');
                ctx2.fillStyle = gradient2;
                ctx2.beginPath();
                ctx2.arc(half, half, half, 0, Math.PI * 2);
                ctx2.fill();
                function random(min, max) {
                    if (arguments.length < 2) {
                        max = min;
                        min = 0;
                    }
                    if (min > max) {
                        var hold = max;
                        max = min;
                        min = hold;
                    }
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                }

                function maxOrbit(x, y) {
                    var max = Math.max(x, y),
                            diameter = Math.round(Math.sqrt(max * max + max * max));
                    return diameter / 2;
                }

                var Star = function () {
                    this.orbitRadius = random(maxOrbit(w, h));
                    this.radius = random(60, this.orbitRadius) / 8;
                    this.orbitX = w / 2;
                    this.orbitY = h / 2;
                    this.timePassed = random(0, maxStars);
                    this.speed = -random(this.orbitRadius) / 80000;
                    this.alpha = random(2, 10) / 10;
                    count++;
                    stars[count] = this;
                }
                Star.prototype.draw = function () {
                    var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
                            y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
                            twinkle = random(10);
                    if (twinkle === 1 && this.alpha > 0) {
                        this.alpha -= 0.05;
                    } else if (twinkle === 2 && this.alpha < 1) {
                        this.alpha += 0.05;
                    }
                    ctx.globalAlpha = this.alpha;
                    ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
                    this.timePassed += this.speed;
                }
                setTimeout(function () {
                    count = 0
                    for (var i = 0; i < maxStars; i++) {
                        new Star();
                    }
                }, 100)
                function animation() {
                    ctx.globalCompositeOperation = 'source-over';
                    ctx.globalAlpha = 0.5; //尾巴
                    ctx.fillStyle = 'hsla(' + hue + ', 64%, 6%, 2)';
                    ctx.fillRect(0, 0, w, h)
                    ctx.globalCompositeOperation = 'lighter';
                    for (var i = 1, l = stars.length; i < l; i++) {
                        stars[i].draw();
                    }

                    animate = window.requestAnimationFrame(animation);
                }

                animation();
            }

            starMove();
            $(window).resize(function () {
                window.cancelAnimationFrame(animate);
                starMove()
            })
        }
    }