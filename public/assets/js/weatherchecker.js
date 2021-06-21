$( document ).ready(function() {
    const cards = $('.weather-card');
    const owmUrlCurrentWeather = 'http://api.openweathermap.org/data/2.5/weather';
    const owmApiKey = 'bb085da98830aaad2383873d152174f9';
    cards.each(function (idx, elm) {
        let card = $(elm);
        let data = card.data();
        $.get(
            owmUrlCurrentWeather,
            {id: data.id, appid: owmApiKey, units: 'metric'},
            function (data,textStatus,jqXHR) {
                card.find('#temp').append(data.main.temp);
                card.find('#humidity').append(data.main.humidity);
            }
        );
    });
});
