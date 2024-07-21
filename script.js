document.addEventListener("DOMContentLoaded", function() {
    const campaigns = document.querySelectorAll('.campaign');
    campaigns.forEach(campaign => {
        const goal = parseInt(campaign.getAttribute('data-goal'));
        const achieved = parseInt(campaign.getAttribute('data-achieved'));
        const achievedElement = campaign.querySelector('.achieved');
        achievedElement.textContent = `Achieved: $${achieved}`;
    });
});
