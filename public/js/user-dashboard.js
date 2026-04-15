// Greeting based on time
function updateGreeting() {
    const hour = new Date().getHours();
    const greetingEl = document.getElementById('greeting');
    let greeting = 'Selamat Datang';
    
    if (hour >= 5 && hour < 12) greeting = 'Selamat Pagi';
    else if (hour >= 12 && hour < 15) greeting = 'Selamat Siang';
    else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore';
    else if (hour >= 18 || hour < 5) greeting = 'Selamat Malam';
    
    if (greetingEl) greetingEl.textContent = greeting;
}

// Animate counters
function animateCounters() {
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.target) || 0;
        const duration = 2000;
        const startTime = performance.now();
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const current = Math.floor(easeOutQuart * target);
            
            counter.textContent = 'Rp ' + current.toLocaleString('id-ID');
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            }
        }
        
        requestAnimationFrame(updateCounter);
    });
}

// Animate chart bars
function animateChartBars() {
    const bars = document.querySelectorAll('.chart-bar');
    bars.forEach((bar, index) => {
        setTimeout(() => {
            const height = bar.dataset.height || 0;
            bar.style.height = height + '%';
        }, index * 100);
    });
}

// Intersection Observer for animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            if (entry.target.classList.contains('counter')) {
                animateCounters();
            }
            if (entry.target.id === 'chart') {
                animateChartBars();
            }
            // unobserve after trigger
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

document.addEventListener('DOMContentLoaded', () => {
    updateGreeting();
    
    document.querySelectorAll('.counter').forEach(el => observer.observe(el));
    document.querySelectorAll('.card-animate').forEach(el => observer.observe(el));
    const chart = document.getElementById('chart');
    if (chart) observer.observe(chart);

    // Initial animation trigger
    window.addEventListener('load', () => {
      setTimeout(() => {
        document.querySelectorAll('.card-animate').forEach(el => {
          const rect = el.getBoundingClientRect();
          if(rect.top < window.innerHeight) el.classList.add('visible');
        });
        animateCounters();
        animateChartBars();
      }, 500);
    });
});
