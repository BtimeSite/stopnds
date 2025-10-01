import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const voteButtons = document.querySelector('.vote-buttons');
    const voteYesBtn = document.getElementById('voteYes');
    const voteNoBtn = document.getElementById('voteNo');
    const votesYesCount = document.getElementById('votesYes');
    const votesNoCount = document.getElementById('votesNo');

    const progressBar = document.getElementById('progressBar');
    const remainingVotes = document.getElementById('remainingVotes');
    const thankYouMessage = document.getElementById('thankYouMessage');
    
    let currentYesVotes = 0;
    let currentNoVotes = 0;
    const goalVotes = 1000000;

    axios.get('/votes')
        .then(({data}) => {
            if (data.success) {
                currentYesVotes = data.votes_yes;
                currentNoVotes = data.votes_no;
                votesYesCount.textContent = currentYesVotes.toLocaleString();
                votesNoCount.textContent = currentNoVotes.toLocaleString();
                updateProgress();
            }
        })
        .catch(err => {
            console.error('Ошибка при получении голосов:', err);
        });
    
    // Обновляем прогресс бар
    function updateProgress() {
        const progressPercentage = (currentYesVotes / goalVotes) * 100;
        progressBar.style.width = `${Math.min(progressPercentage, 100)}%`;
        remainingVotes.textContent = (goalVotes - currentYesVotes).toLocaleString();
    }
    
    // Анимация при голосовании
    function animateVote(button) {
        button.classList.remove('pulse');
        void button.offsetWidth; // Перезапуск анимации
        button.classList.add('pulse');
        
        // Создаем эффект частиц
        createParticles(button);
    }
    
    // Создаем частицы для анимации
    function createParticles(button) {
        const rect = button.getBoundingClientRect();
        const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];
        
        for (let i = 0; i < 15; i++) {
            const particle = document.createElement('div');
            particle.style.position = 'fixed';
            particle.style.width = '8px';
            particle.style.height = '8px';
            particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            particle.style.borderRadius = '50%';
            particle.style.left = `${rect.left + rect.width/2}px`;
            particle.style.top = `${rect.top + rect.height/2}px`;
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '1000';
            
            const angle = Math.random() * Math.PI * 2;
            const distance = 50 + Math.random() * 50;
            const duration = 0.5 + Math.random() * 0.5;
            
            particle.style.transition = `all ${duration}s ease-out`;
            document.body.appendChild(particle);
            
            // Запускаем анимацию
            setTimeout(() => {
                particle.style.transform = `translate(${Math.cos(angle) * distance}px, ${Math.sin(angle) * distance}px)`;
                particle.style.opacity = '0';
            }, 10);
            
            // Удаляем частицу после анимации
            setTimeout(() => {
                particle.remove();
            }, duration * 1000);
        }
    }

    function sendVote(choice)
    {
        axios.post('/vote', {
            choice
        })
        .then(({data}) => {
            if (data.success) {
                currentYesVotes = data.votes_yes;
                currentNoVotes = data.votes_no;
                votesYesCount.textContent = currentYesVotes.toLocaleString();
                votesNoCount.textContent = currentNoVotes.toLocaleString();

                // обновляем прогресс
                updateProgress();

                // анимация
                if(choice == 'yes'){
                    animateVote(voteYesBtn);
                }else {
                    animateVote(voteNoBtn);
                }

                // цель достигнута
                if (currentYesVotes >= goalVotes) {
                    setTimeout(() => {
                        alert('Цель достигнута! 1,000,000 голосов собрано! Спасибо за участие!');
                    }, 800);
                }
            } else {
                alert(data.message || 'Вы уже голосовали');
            }
            voteButtons.style.display = 'none';
            thankYouMessage.style.display = 'block';
        })
        .catch(err => {
            console.error(err);
            alert('Ошибка при отправке голоса');
        });
    }
    
    // Обработчик голосования
    voteYesBtn.addEventListener('click', () => sendVote('yes'));
    voteNoBtn.addEventListener('click', () => sendVote('no'));
    
    // Инициализация прогресс бара
    updateProgress();
});