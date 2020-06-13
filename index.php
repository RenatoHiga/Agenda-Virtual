<?php 

    $db_connection = mysqli_connect("127.0.0.1", "root", "", "agenda_virtual");

    $elements_of_today_date = explode(' ', date('Y F d l')); // Year, Name of the Month, Number of the Day, Week day
    
    $month  = $elements_of_today_date[1];
    $year   = $elements_of_today_date[0];
    $day    = $elements_of_today_date[2];
    $day_of_the_week = $elements_of_today_date[3];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agenda</title>

        <link rel="stylesheet" href="css/style.css">

    </head>
    
    <body>
    
        <div class="container">

            <div class="current_time_container">

                <div class="centering_container">
                    <h1 class="current_year_and_month">
                        <?php
                        echo $month." ".$year;
                        ?>    
                    </h1>
                </div>
                
                <div class="centering_container">
                    <span class="current_day">
                        <?php 
                        echo $day;
                        ?>
                    </span>
                </div>
                
                <div class="centering_container">
                    <h2 class="current_day_of_the_week">
                        <?php
                        echo $day_of_the_week;
                        ?>
                    </h2>
                </div>
               
            </div>
            

            <div class="centering_container container_welcome_text">
                <p class="welcome_text">
                    Good Morning, Renato! Welcome Back!<br><br>
                    Keep up with the good habits! :)
                </p>
            </div>
            

            <div class="centering_container">
                
                
                <div class="rounded_button" id="add_anotation_button">
                    
                    <p class="button_anotation_description" id="add_anotation_desc">Add new Anotation</p>
                    <img src="img/adicionar_nota.png" class="button_image">
            
                </div>
               
                
                <div class="rounded_button" id="list_all_anotations_button">
                    
                    <p class="button_list_description" id="list_anotations_desc">List all Anotations</p>
                    <img src="img/lista_anotacoes.png" class="button_image">

                </div>
                
            </div>

        </div>

        <div class="modal_annotation" id="modal_annotation">

            <img src="img/close_modal_icon.png" class="close_modal_button" alt="Close">
            
            <div class="container_annotation">
                <h1>Add a new Annotation</h1>
                <textarea name="" id="annotation_text" class="annotation_input_text" placeholder="Write here an annotation"></textarea>
                <button class="add_annotation_button" id="add_new_annotation">
                    <span>+ Add Annotation</span>
                </button>   
            </div>
            
        </div>

        <div class="modal_list_annotations" id="modal_list_annotations">
            <img src="img/close_modal_icon.png" class="close_modal_button" alt="Close">
        
            <div class="container_list_anotations">
                <table class="table_annotations">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Text</th>
                            <th>Creation Date</th>
                        </tr>
                    </thead>
                
                    <tbody id="list_annotations_body">
                        <tr>
                            <td>123</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet natus aspernatur dolorum? Expedita praesentium tempora quos alias aut nulla, iure eveniet repellat, quo nobis dolor ipsa quidem obcaecati illo necessitatibus.</td>
                            <td>12/12/2020 19:12:20</td>
                        </tr>
                    </tbody>
                
                </table>
            </div>
        </div>

        <div class="modal_loading" id="modal_loading">

            <div class="loading_container">
                <h1>Loading, Please Wait...</h1>
                <img class="img_loader" src="img/loader.svg" alt="Loading... Please Wait">
            </div>

        </div>

        <script>
            const add_anotation_button = document.getElementById('add_anotation_button');
            const list_all_anotations_button = document.getElementById('list_all_anotations_button');

            const add_anotation_description = document.getElementById('add_anotation_desc');
            const list_anotations_description = document.getElementById('list_anotations_desc');
            
            const close_button_modal = document.getElementsByClassName('close_modal_button');
            
            const modal_annotation = document.getElementById('modal_annotation');
            const modal_list_annotations = document.getElementById('modal_list_annotations');
            const modal_loading = document.getElementById('modal_loading');

            add_anotation_button.addEventListener("mouseenter", showAddAnotationDescription);
            add_anotation_button.addEventListener("mouseleave", hideAddAnotationDescription);
            add_anotation_button.addEventListener("click", () => {
                showModal(modal_annotation);
            });

            list_all_anotations_button.addEventListener("mouseenter", showListAnotationsDescription);
            list_all_anotations_button.addEventListener("mouseleave", hideListAnotationsDescription);
            list_all_anotations_button.addEventListener("click", () => {
                showModal(modal_list_annotations);
            })
            
            close_button_modal[0].addEventListener('click', function() {
                hideModal(modal_annotation);
            });
            
            close_button_modal[1].addEventListener('click', () => {
                hideModal(modal_list_annotations);
            });

            function showAddAnotationDescription() {
                add_anotation_description.style.display = "block";
            }

            function hideAddAnotationDescription() {
                add_anotation_description.style.display = "none";
            }

            function showListAnotationsDescription() {
                list_anotations_description.style.display = "block";
            }

            function hideListAnotationsDescription() {
                list_anotations_description.style.display = "none";
            }

            function showModal(modal) {
                modal.style.display = "block";
            }

            function hideModal(modal) {
                modal.style.display = "none";
            }

            /* Ajax */
            const add_new_annotation_button = document.getElementById('add_new_annotation');
            add_new_annotation_button.addEventListener('click', () => {

                let httpRequest = new XMLHttpRequest();
                modal_loading.style.display = "block";

                const text = document.getElementById('annotation_text').value;

                httpRequest.onreadystatechange = (data) => {
                    
                    if (httpRequest.readyState === XMLHttpRequest.DONE) {
                        modal_loading.style.display = "none";
                        if (httpRequest.status === 200) {
                            console.log(httpRequest.responseText);
                        } else {
                            console.log("Ocorreu algum erro!");
                        }

                    }
                    
                }

                httpRequest.open("POST", "server/create_new_annotation.php");
                httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                httpRequest.send("text="+encodeURI(text));

            });

            list_all_anotations_button.addEventListener('click', () => {

                let httpRequest = new XMLHttpRequest();
                modal_loading.style.display = "block";

                const body_list = document.getElementById('list_annotations_body');

                httpRequest.onreadystatechange = () => {
                    if (httpRequest.readyState === XMLHttpRequest.DONE) {
                        
                        modal_loading.style.display = "none";

                        if (httpRequest.status === 200) {
                            const list_annotations = JSON.parse(httpRequest.responseText);
                            let html_annotations_rows = "";
                            console.log(list_annotations);
                            for (index = 0; index <= list_annotations.length - 1; index++) {
                                
                                html_annotations_rows += "<tr>"+
                                    "<td>"+ list_annotations[index][0] +"</td>"+
                                    "<td>"+ list_annotations[index][1] +"</td>"+
                                    "<td>"+ list_annotations[index][2]+"</td>"+
                                "</tr>"
                            }

                            body_list.innerHTML = html_annotations_rows;
                        } else {
                            console.log("Error!");
                        }

                    }
                }

                httpRequest.open("GET", "server/get_all_annotations.php");
                httpRequest.send();

            });
            
        </script>

    </body>
</html>