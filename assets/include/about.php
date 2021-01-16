<?php 


if ($info->mobile === false) {
    echo '<link rel="stylesheet" href="/forum/assets/style/pc.about.css">';

   
    if (isset($rargs["show"]) && $rargs["show"] === "about") {
        echo '<div class="about-block theme-main-color-1">';
        echo '
        <div class="about-block-extended">
            <div class="about-us about-entry">
                <h2 class="about-us-title about-sub-title">Wir sind Wir?</h2>
                <p class="about-us-text about-sub-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>
            </div>
            <div class="about-goal about-entry">
                <h2 class="about-us-title about-sub-title">Unser Ziel mit diesem Projekt</h2>
                <p class="about-us-text about-sub-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>
            </div>
            <div class="about-other-projects about-entry">
                <h2 class="about-us-title about-sub-title">Andere projekte</h2>
                <p class="about-us-text about-sub-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>
            </div>
        </div>
        ';
        echo '<div class="about-collab">';
        echo '<h1 class="about-collab-heading">Collaborators:</h1>';
        echo '<div class="about-collab-flex">';
        foreach($data->get_user_collaborators() as $row) {
            echo '
                <a class="about-collaborator-anchor" href="' . $row["collaboratorLink"] . '" id="a-c-' . $row["collaboratorId"] . '">
                <span class="about-collaborator">
                    <p class="about-collaborator-name">' . $row["collaboratorName"] . '</p>
                    <p class="about-collaborator-lore">' . $row["collaboratorLore"] . '</p>
                </span>
                <span style="display: none;" class="about-collaborator-description" id="a-c-d-' . $row["collaboratorId"] . '"><p class="about-collaborator-d-t">' . $row["collaboratorDescription"] . '</p></span>
                <span style="display: none;" class="about-collaborator-visit" id="a-c-v-' . $row["collaboratorId"] . '" linkref="' . $row["collaboratorLink"] . '">Visit Profile</span>
                </a>
                <script>
                    document.getElementById("a-c-' . $row["collaboratorId"] . '").addEventListener("click", (e) => {
                        e.preventDefault();
                        if (document.getElementById("a-c-d-' . $row["collaboratorId"] . '").style.display === "none") {
                            const all_collab_descriptions = document.querySelectorAll(".about-collaborator-description");
                            for (let i = 0; i < all_collab_descriptions.length; i++) {
                                all_collab_descriptions[i].style.display = "none";
                                all_collab_descriptions[i].style.zIndex = "0";
                            }
                            const all_collab_anchors = document.querySelectorAll(".about-collaborator-anchor");
                            for (let i = 0; i < all_collab_anchors.length; i++) {
                                all_collab_anchors[i].style.zIndex = "0";
                            }
                            const all_collab_visits = document.querySelectorAll(".about-collaborator-visit");
                            for (let i = 0; i < all_collab_visits.length; i++) {
                                all_collab_visits[i].style.display = "none";
                            }
                            document.getElementById("a-c-d-' . $row["collaboratorId"] . '").style.display = "";
                            document.getElementById("a-c-v-' . $row["collaboratorId"] . '").style.display = "";
                            document.getElementById("a-c-' . $row["collaboratorId"] . '").style.zIndex = "1";
                        } else {
                            document.getElementById("a-c-d-' . $row["collaboratorId"] . '").style.display = "none";
                            document.getElementById("a-c-v-' . $row["collaboratorId"] . '").style.display = "none";
                        }
                    })

                    document.getElementById("a-c-v-' . $row["collaboratorId"] . '").addEventListener("click", (e) => {
                        window.location=e.target.getAttribute("linkref");
                    })
                </script>
                ';
        }
        echo '</div></div></div>';
    } else {
        echo '<div class="about-collab about-collab-alone theme-main-color-2">';
        echo '<h1 class="about-collab-heading">Collaborators:</h1>';
        echo '<div class="about-collab-flex">';
        foreach($data->get_user_collaborators() as $row) {
            echo '
                <a class="about-collaborator-anchor" href="' . $row["collaboratorLink"] . '" id="a-c-' . $row["collaboratorId"] . '">
                <span class="about-collaborator">
                    <p class="about-collaborator-name">' . $row["collaboratorName"] . '</p>
                    <p class="about-collaborator-lore">' . $row["collaboratorLore"] . '</p>
                </span>
                <span style="display: none;" class="about-collaborator-description" id="a-c-d-' . $row["collaboratorId"] . '"><p class="about-collaborator-d-t">' . $row["collaboratorDescription"] . '</p></span>
                <span style="display: none;" class="about-collaborator-visit" id="a-c-v-' . $row["collaboratorId"] . '" linkref="' . $row["collaboratorLink"] . '">Visit Profile</span>
                </a>
                <script>
                    document.getElementById("a-c-' . $row["collaboratorId"] . '").addEventListener("click", (e) => {
                        e.preventDefault();
                        if (document.getElementById("a-c-d-' . $row["collaboratorId"] . '").style.display === "none") {
                            const all_collab_descriptions = document.querySelectorAll(".about-collaborator-description");
                            for (let i = 0; i < all_collab_descriptions.length; i++) {
                                all_collab_descriptions[i].style.display = "none";
                                all_collab_descriptions[i].style.zIndex = "0";
                            }
                            const all_collab_anchors = document.querySelectorAll(".about-collaborator-anchor");
                            for (let i = 0; i < all_collab_anchors.length; i++) {
                                all_collab_anchors[i].style.zIndex = "0";
                            }
                            const all_collab_visits = document.querySelectorAll(".about-collaborator-visit");
                            for (let i = 0; i < all_collab_visits.length; i++) {
                                all_collab_visits[i].style.display = "none";
                            }
                            document.getElementById("a-c-d-' . $row["collaboratorId"] . '").style.display = "";
                            document.getElementById("a-c-v-' . $row["collaboratorId"] . '").style.display = "";
                            document.getElementById("a-c-' . $row["collaboratorId"] . '").style.zIndex = "1";
                        } else {
                            document.getElementById("a-c-d-' . $row["collaboratorId"] . '").style.display = "none";
                            document.getElementById("a-c-v-' . $row["collaboratorId"] . '").style.display = "none";
                        }
                    })

                    document.getElementById("a-c-v-' . $row["collaboratorId"] . '").addEventListener("click", (e) => {
                        window.location=e.target.getAttribute("linkref");
                    })
                </script>
                ';
        }
        echo '</div></div>';
    }

    

    echo '</div>';
} else {

}