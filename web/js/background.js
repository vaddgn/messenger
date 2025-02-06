
const canvas = document.getElementById('myCanvas');
const ctx = canvas.getContext('2d');

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

class Circle {
    constructor(x, y, radius, opacity, speed) {
        this.x = x;
        this.y = y;
        this.radius = radius;
        this.opacity = opacity;
        this.speed = speed;
    }

    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(13, 109, 252, ${this.opacity})`;
        ctx.fill();
        ctx.closePath();
    }

    update() {
        this.y -= this.speed; 
        if (this.y + this.radius < 0) {
            this.y = canvas.height + this.radius;  
            this.x = Math.random() * canvas.width;  
            this.opacity = Math.random() * 0.5 + 0.3; 
        }
        this.draw();
    }
}

let circles = [];
for (let i = 0; i < 10; i++) {
    let radius = Math.random() * 5 + 10;  
    let x = Math.random() * canvas.width;
    let y = Math.random() * canvas.height + canvas.height;  
    let opacity = Math.random() * 0.4 + 0.2;  
    let speed = Math.random() * 0.2 + 1;  
    circles.push(new Circle(x, y, radius, opacity, speed));
}


function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);  
    circles.forEach(circle => circle.update());  
    requestAnimationFrame(animate); 
}

animate();