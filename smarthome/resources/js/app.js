import './bootstrap';

// Exemple de script pour les boutons ON/OFF
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.card button').forEach(button => {

        button.addEventListener('click', function () {

            const card = button.closest('.card');
            const dataDiv = card.querySelector('.data');
            const icon = button.querySelector('i');

            let state = dataDiv.textContent.trim();

            if (state === 'ON') {
                dataDiv.textContent = 'OFF';
                dataDiv.classList.remove('text-green-500');
                dataDiv.classList.add('text-red-500');

                icon.classList.remove('bi-toggle-on', 'text-green-500');
                icon.classList.add('bi-toggle-off', 'text-red-500');

                alert('Lumière éteinte !');

            } else if (state === 'OFF') {
                dataDiv.textContent = 'ON';
                dataDiv.classList.remove('text-red-500');
                dataDiv.classList.add('text-green-500');

                icon.classList.remove('bi-toggle-off', 'text-red-500');
                icon.classList.add('bi-toggle-on', 'text-green-500');

                alert('Lumière allumée !');

            } else if (state === 'UP') {
                dataDiv.textContent = 'DOWN';
                dataDiv.classList.remove('text-green-500');
                dataDiv.classList.add('text-red-500');

                icon.classList.remove('bi-toggle-on', 'text-green-500');
                icon.classList.add('bi-toggle-off', 'text-red-500');

                alert('Volet baissé !');

            } else {
                dataDiv.textContent = 'UP';
                dataDiv.classList.remove('text-red-500');
                dataDiv.classList.add('text-green-500');

                icon.classList.remove('bi-toggle-off', 'text-red-500');
                icon.classList.add('bi-toggle-on', 'text-green-500');

                alert('Volet levé !');
            }

        });

    });

});


setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) alert.style.display = 'none';
}, 3000);
