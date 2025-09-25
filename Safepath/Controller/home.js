let currentSlide = 0;

        function moveSlide(direction) {
            const cards = document.querySelectorAll('.incident-card');
            const totalCards = cards.length;

            if (direction === 1) {
                currentSlide = (currentSlide + 1) % totalCards;
            } else {
                currentSlide = (currentSlide - 1 + totalCards) % totalCards;
            }

            updateSliderPosition();
        }

        function updateSliderPosition() {
            const cards = document.querySelectorAll('.incident-card');
            const offset = -currentSlide * 100;
            cards.forEach(card => {
                card.style.transform = `translateX(${offset}%)`;
            });
        }