function bubbles(){
	var count = 200;
	var section = document.querySelector('section');
	var i = 0;
	while (i < count){
		var bubble = document.createElement('i');
		var x = Math.floor(Math.random() * window.innerWidth);
		var y = Math.floor(Math.random() * window.innerHeight);
		var size = Math.random() * 10;
		bubble.style.left = x+'px';
		bubble.style.top = y+'px';
		bubble.style.width = 1+size+'px';
		bubble.style.height = 1+size+'px';
		bubble.style.animationDuration = 5+size+'s';
		bubble.style.animationDelay = -size+'s';
		section.appendChild(bubble);
		i++
	}
}
bubbles()


const hour = document.getElementById("hour");
const minute = document.getElementById("minute");
const seconds = document.getElementById("seconds");

const clock = setInterval(function time() {
  const dateNow = new Date();
  let hr = dateNow.getHours();
  let min = dateNow.getMinutes();
  let sec = dateNow.getSeconds();

  hr = hr.toString().padStart(2, "0");
  min = min.toString().padStart(2, "0");
  sec = sec.toString().padStart(2, "0");

  const timeString = `${hr}:${min}:${sec}`;
  hour.textContent = hr;
  minute.textContent = min;
  seconds.textContent = sec;
}, 1000);