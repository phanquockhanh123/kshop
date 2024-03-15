<!DOCTYPE html>
<html lang="en">
</head>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet" />

<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="main">
        <form id="multistep_form">
            <!-- progressbar -->
            <ul id="progress_header">
                <li class="active"></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <!-- Step 01 -->
            <div class="multistep-box">
                <div class="title-box">
                    <h2>Select Options</h2>
                </div>
                <p>
                <h3>Please select a meal</h3>
                <select name="meal" id="meal">
                    <option value="">Choose meal</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Dinner">Dinner</option>
                </select>
                <span id="error-meal"></span>
                </p>
                <p>
                <h3>Please enter number of people</h3>
                <input type="text" name="people" placeholder="Please enter number of people" id="people">
                <span id="error-people"></span>
                </p>
                <p class="nxt-prev-button"><input type="button" name="next" class="fs_next_btn action-button"
                        value="Next" /></p>
            </div>
            <!-- Step 02 -->
            <div class="multistep-box">
                <div class="title-box">
                    <h2>Restaurant</h2>
                </div>
                <p>
                <h3>Please select a restaurant</h3>
                <select name="restaurant" id="restaurant">
                    <option value="">Choose restaurant</option>
                    <option value="Ha Noi">Ha Noi</option>
                    <option value="Da Nang">Da Nang</option>
                    <option value="HCM">HCM</option>
                </select>
                <span id="error-restaurant"></span>
                </p>
                <p class="nxt-prev-button"><input type="button" name="next" class="ss_next_btn action-button"
                        value="Next" />
                <p class="nxt-prev-button"><input type="button" name="previous" class="previous action-button"
                        value="Previous" />
            </div>
            <!-- Step 03 -->
            <div class="multistep-box">
                <div class="title-box">
                    <h2>Dishes</h2>
                    <p class="button"><input type="button" id="add-option" class="addOption action-button"
                            value="Add" />
                </div>
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th scope="col">Select a dish</th>
                            <th scope="col">No of services</th>
                        </tr>
                    </thead>
                    <tbody id="tbody" name="tbody">
                        <tr id="sectionMain" name="sectionMain">
                            <td>
                                <select name="dish[]" id="dish[]">
                                    <option value="">Choose dish</option>
                                    <option value="Fish">Fish</option>
                                    <option value="Meat">Meat</option>
                                    <option value="Vegetables">Vegetables</option>
                                </select>
                                <span id="error-dish"></span>
                            </td>
                            <td>
                                <input type="text" name="no-service[]" id="no-service[]">
                                <span id="error-no-service"></span>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="nxt-prev-button"><input type="button" name="next" class="ts_next_btn action-button"
                        value="Next" />
                <p class="nxt-prev-button"><input type="button" name="previous" class="previous action-button"
                        value="Previous" />
            </div>
            <!-- Step 04 -->
            <div class="multistep-box" width="100%">
                <div class="title-box">
                    <h2>Review</h2>
                </div>
                <table width="80%">
                    <tr>
                        <th>Meal</th>
                        <td>
                            <p id="meal-view"></p>
                        </td>
                    </tr>
                    <tr>
                        <th>People</th>
                        <td id="people-view"></td>
                    </tr>
                    <tr>
                        <th>Restaurant</th>
                        <td id="restaurant-view"></td>
                    </tr>
                    <tr>
                        <th>Dishes</th>
                        <td>
                            <table width="95%" border="1px solid black" style="border-collapse: collapse;">
                                <tr>
                                    <th>Dish Name</th>
                                    <th>Service</th>
                                </tr>
                                <tbody id="table-body"></tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <p class="nxt-prev-button"><input type="button" name="previous" class="previous action-button"
                        value="Previous" />
                    <input type="submit" name="submit" class="submit_btn fos_next_btn action-button"
                        value="Submit" />
                </p>
            </div>
        </form>
        <h1>You are successfully</h1>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.0/jquery.easing.js" type="text/javascript">
    </script>
    <script>
        var current_slide, next_slide, previous_slide;
        var left, opacity, scale;
        var animation;

        var error = false;

        // meal validation
        $("#meal").keyup(function() {
            var meal = $("#meal").val();
            if (meal == '') {
                $("#error-meal").text('Please enter an meal.');
                $("#meal").addClass("box_error");
                error = true;
            } else {
                $("#error-meal").text('');
                error = false;
                $("#meal").removeClass("box_error");
            }
        });

        // people validation
        $("#people").keyup(function() {
            var people = $("#people").val();

            if (people == '') {
                $("#error-people").text('Please enter number people.');
                $("#people").addClass("box_error");
                error = true;
            } else if (people < 1 || people > 10 || isNaN(people)) {
                $("#error-people").text('Please enter people less than 10.');
                $("#people").addClass("box_error");
                error = true;
            } else {
                $("#error-people").text('');
                error = false;
                $("#people").removeClass("box_error");
            }
        });

        // restaurant validation
        $("#restaurant").keyup(function() {
            var restaurant = $("#restaurant").val();
            if (restaurant == '') {
                $("#error-restaurant").text('Please enter an restaurant.');
                $("#restaurant").addClass("box_error");
                error = true;
            } else {
                $("#error-restaurant").text('');
                error = false;
                $("#restaurant").removeClass("box_error");
            }
        });

        // dish validation
        $("#dish").keyup(function() {
            var dish = $("#dish").val();
            if (dish == '') {
                $("#error-dish").text('Please enter an dish.');
                $("#dish").addClass("box_error");
                error = true;
            } else {
                $("#error-dish").text('');
                error = false;
                $("#dish").removeClass("box_error");
            }
        });

        // no-service validation
        $("#no-service").keyup(function() {
            var noservice = $("#no-service").val();

            if (noservice == '') {
                $("#error-no-service").text('Please enter number no-service.');
                $("#no-service").addClass("box_error");
                error = true;
            } else if (noservice < 1 || noservice > 10 || isNaN(noservice)) {
                $("#error-no-service").text('Please enter no-service less than 10.');
                $("#no-service").addClass("box_error");
                error = true;
            } else {
                $("#error-no-service").text('');
                error = false;
                $("#no-service").removeClass("box_error");
            }
        });

        // first step validation
        $(".fs_next_btn").click(function() {
            // people
            if ($("#people").val() == '') {
                $("#error-people").text('Please enter number people.');
                $("#people").addClass("box_error");
                errorPeople = true;
            } else if ($("#people").val() > 10 || $("#people").val() < 1 || isNaN($("#people").val())) {
                $("#error-people").text('Please enter people less than 10.');
                $("#people").addClass("box_error");
                errorPeople = true;
            } else {
                errorPeople = false;
                $("#error-people").text('');
                $("#people").removeClass("box_error");
            }

            // meal
            if ($("#meal").val() == '') {
                $("#error-meal").text('Please enter an meal.');
                $("#meal").addClass("box_error");
                errorMeal = true;
            } else {
                $("#error-meal").text('');
                $("#meal").removeClass("box_error");
                errorMeal = false;
            }

            // restaurant validation
            $("#restaurant").keyup(function() {
                var restaurant = $("#restaurant").val();
                if (restaurant == '') {
                    $("#error-restaurant").text('Please enter an restaurant.');
                    $("#restaurant").addClass("box_error");
                    error = true;
                } else {
                    $("#error-restaurant").text('');
                    error = false;
                    $("#restaurant").removeClass("box_error");
                }
            });

            // dish validation
            $("#dish").keyup(function() {
                var dish = $("#dish").val();
                if (dish == '') {
                    $("#error-dish").text('Please enter an dish.');
                    $("#dish").addClass("box_error");
                    error = true;
                } else {
                    $("#error-dish").text('');
                    error = false;
                    $("#dish").removeClass("box_error");
                }
            });

            // animation
            if (!errorMeal && !errorPeople) {
                if (animation) return false;
                animation = true;

                const peopleData = $("#people").val();

                const mealData = $("#meal").val();

                localStorage.setItem("meal", mealData);
                localStorage.setItem("people", peopleData);

                current_slide = $(this).parent().parent();
                next_slide = $(this).parent().parent().next();

                $("#progress_header li").eq($(".multistep-box").index(next_slide)).addClass("active");

                next_slide.show();
                current_slide.animate({
                    opacity: 0
                }, {
                    step: function(now, mx) {
                        scale = 1 - (1 - now) * 0.2;
                        left = (now * 50) + "%";
                        opacity = 1 - now;
                        current_slide.css({
                            'transform': 'scale(' + scale + ')'
                        });
                        next_slide.css({
                            'left': left,
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_slide.hide();
                        animation = false;
                    },
                    easing: 'easeInOutBack'
                });
            }
        });
        // second step validation
        $(".ss_next_btn").click(function() {
            // restaurant
            if ($("#restaurant").val() == '') {
                $("#error-restaurant").text('Please enter an restaurant.');
                $("#restaurant").addClass("box_error");
                error = true;
            } else {
                $("#error-restaurant").text('');
                $("#restaurant").removeClass("box_error");
                error = false;
            }

            if (!error) {
                if (animation) return false;
                animation = true;

                const secondData = $("#restaurant").val();
                localStorage.setItem("restaurant", secondData);

                current_slide = $(this).parent().parent();
                next_slide = $(this).parent().parent().next();

                $("#progress_header li").eq($(".multistep-box").index(next_slide)).addClass("active");

                next_slide.show();
                current_slide.animate({
                    opacity: 0
                }, {
                    step: function(now, mx) {
                        scale = 1 - (1 - now) * 0.2;
                        left = (now * 50) + "%";
                        opacity = 1 - now;
                        current_slide.css({
                            'transform': 'scale(' + scale + ')'
                        });
                        next_slide.css({
                            'left': left,
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_slide.hide();
                        animation = false;
                    },
                    easing: 'easeInOutBack'
                });
            }

        });

        // third step validation
        $(".ts_next_btn").click(function() {
            // restaurant
            if ($("#dish").val() == '') {
                $("#error-dish").text('Please enter an dish.');
                $("#dish").addClass("box_error");
                error = true;
            } else {
                $("#error-dish").text('');
                $("#dish").removeClass("box_error");
                error = false;
            }

            if (!error) {
                if (animation) return false;
                animation = true;

                dishValues = [];
                noServiceValues = [];

                // get calue from id
                var dishElements = document.querySelectorAll('select[name="dish[]"]');
                var noServiceElements = document.querySelectorAll('input[name="no-service[]"]');

                // dishes elememt
                dishElements.forEach(function(element) {
                    dishValues.push(element.value);
                });

                localStorage.setItem("dishes", JSON.stringify(dishValues));

                // services element
                noServiceElements.forEach(function(element) {
                    noServiceValues.push(element.value);
                });
                localStorage.setItem("services", JSON.stringify(noServiceValues));

                document.getElementById("meal-view").innerHTML = localStorage.getItem("meal");
                document.getElementById("people-view").innerHTML = localStorage.getItem("people");
                document.getElementById("restaurant-view").innerHTML = localStorage.getItem("restaurant");

                var storedDishes = JSON.parse(localStorage.getItem("dishes"));

                var storedServices = JSON.parse(localStorage.getItem("services"));

                // Get the table body element
                const tableBody = document.getElementById('table-body');

                // Loop through the stored dishes and services and populate the table rows
                for (let i = 0; i < storedDishes.length; i++) {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `<td>${storedDishes[i]}</td><td>${storedServices[i]}</td>`;
                    tableBody.appendChild(newRow);
                }

                current_slide = $(this).parent().parent();
                next_slide = $(this).parent().parent().next();

                $("#progress_header li").eq($(".multistep-box").index(next_slide)).addClass("active");

                next_slide.show();
                current_slide.animate({
                    opacity: 0
                }, {
                    step: function(now, mx) {
                        scale = 1 - (1 - now) * 0.2;
                        left = (now * 50) + "%";
                        opacity = 1 - now;
                        current_slide.css({
                            'transform': 'scale(' + scale + ')'
                        });
                        next_slide.css({
                            'left': left,
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_slide.hide();
                        animation = false;
                    },
                    easing: 'easeInOutBack'
                });
            }

        });

        // previous
        $(".previous").click(function() {
            if (animation) return false;
            animation = true;

            current_slide = $(this).parent().parent();
            previous_slide = $(this).parent().parent().prev();

            $("#progress_header li").eq($(".multistep-box").index(current_slide)).removeClass("active");

            previous_slide.show();
            current_slide.animate({
                opacity: 0
            }, {
                step: function(now, mx) {
                    scale = 0.8 + (1 - now) * 0.2;
                    left = ((1 - now) * 50) + "%";
                    opacity = 1 - now;
                    current_slide.css({
                        'left': left
                    });
                    previous_slide.css({
                        'transform': 'scale(' + scale + ')',
                        'opacity': opacity
                    });
                },
                duration: 800,
                complete: function() {
                    current_slide.hide();
                    animation = false;
                },
                easing: 'easeInOutBack'
            });
        });

        $(".submit_btn").click(function() {
            if (!error) {
                $(".main").addClass("form_submited");

                var jsonData = {
                    'dishes': [{
                        'meal' : localStorage.getItem('meal'),
                        'people' : localStorage.getItem('people'),
                        'restaurant' : localStorage.getItem('restaurant'),
                        'dishes' : localStorage.getItem('dishes'),
                        'services' : localStorage.getItem('services')
                    }],
                };

                console.log(JSON.stringify(jsonData));
                // Make the API call
                fetch('http://localhost:8010/api/v1/save-json', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(jsonData),
                    })
                    .then(response => {
                        // Handle the response
                        if (response.ok) {
                            // If the response is successful (status 2xx), you can do something here
                            console.log('Data saved successfully');
                        } else {
                            // If the response has an error status (4xx or 5xx), handle the error
                            console.error('Failed to save data:', response.statusText);
                        }
                    })
                    .catch(error => {
                        // Handle any network errors or exceptions
                        console.error('Error:', error);
                    });
            }
            return false;
        })

        $(".addOption").click(function(e) {
            e.preventDefault();
            var body = document.getElementById("tbody");
            var section = document.getElementById("sectionMain");
            body.appendChild(section.cloneNode(true));
        })
    </script>
</body>

</html>
