<?php
    function get_chat($contacts, $chats, $photo_user, $id_match) {
        global $id_user;

        if (count($contacts) > 0) {
            $contacts_list = "";
            $messages = "";

            foreach ($contacts as $contact) {
                $contacts_list = $contacts_list . get_contact($contact);
                $messages = $messages . get_connection_message($contact);
            }
            
            foreach ($chats as $chat) {
                $messages = $messages . get_message($chat, $photo_user);
            }

            if ($id_match) {
                $trigger_chat = <<<TRIGGERCHAT
                    window.onload = function() {
                        change_tab("messages");
                        filter_messages({$id_match});
                        scroll_bottom("scrolleable");
                    }
TRIGGERCHAT;
            } else {
                $trigger_chat = "";
            }

            $chat = <<<CHAT
                <!-- Content -->
                <div class="row justify-content-center">
                    <div class="col-xl-12 col-lg-12 col-md-9">
                        <div class="card border-0 shadow-lg">
                            <!-- https://mdbootstrap.com/docs/standard/extended/chat/ -->
                            <div class="card shadow">
                                <!-- Tab List -->
                                <div class="card-header p-0">
                                    <ul id="myTab" class="card-header nav nav-tabs m-0 p-0" role="tablist">
                                        <!-- Contacts Tab Button -->
                                        <li class="nav-item" role="presentation">
                                            <button id="contacts-tab" class="nav-link active" data-toggle="tab" data-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="true" onclick="scroll_top('scrolleable');">
                                                <i class="fa-solid fa-users"></i>
                                            </button>
                                        </li>
                
                                        <!-- Messages Tab Button -->
                                        <li class="nav-item" role="presentation">
                                            <button id="messages-tab" class="nav-link" data-toggle="tab" data-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false" disabled>
                                                <i class="fa-solid fa-message"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                    
                                <!-- Tab Content -->
                                <div id="scrolleable" class="card-body custom-height">
                                    <div id="myTabContent" class="tab-content">
                                        <!-- Contacts Tab -->
                                        <div id="contacts" class="tab-pane fade show active" role="tabpanel" aria-labelledby="contacts-tab">
                                            <!-- Search Bar -->
                                            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                                <div class="input-group">
                                                    <input type="text" class="form-control flexbg-light border-0 small" placeholder="Buscar contacto..." aria-label="Search" aria-describedby="basic-addon2" oninput="filter_contacts(event);" regex = /^[0-9a-zA-Z\_]+$/>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button">
                                                            <i class="fas fa-search fa-sm"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <!-- Contacts -->
                                            <div data-mdb-perfect-scrollbar="true">
                                                <ul class="list-unstyled mb-0">
                                                    {$contacts_list}
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Messages Tab -->
                                        <div id="messages" class="tab-pane fade" role="tabpanel" aria-labelledby="messages-tab">
                                            <!-- Messages -->
                                            <ul class="pt-3 pe-3 d-inline-block w-100" data-mdb-perfect-scrollbar="true">
                                                {$messages}
                                            </ul>
                                
                                            <!-- Text Box -->
                                            <form id="chat" class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2" name="chat" method="POST">
                                                <input id="id_match" name="id_match" value="-1" hidden />

                                                <input id="message-new" class="form-control form-control-lg" name="message" type="text" placeholder="Escribe tu mensaje..." required />

                                                <button class="ms-3 btn" type="submit">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    function filter_contacts(e) {
                        let contacts = document.querySelectorAll(".contact");
                        contacts.forEach(contact => contact.classList.remove("hide"));
                        
                        let value = e.target.value.toLowerCase();
                        if (value) {
                            contacts = document.querySelectorAll(".contact:not([id*=" + value + "])");
                            contacts.forEach(contact => contact.classList.add("hide"));
                        }
                    }

                    function filter_messages(id_match) {
                        let messages = document.querySelectorAll(".message");
                        messages.forEach(message => message.classList.remove("hide"));
                        
                        document.querySelector("#id_match").value = id_match;
                        
                        let value = "message-" + id_match.toString() + "-";
                        messages = document.querySelectorAll(".message:not([id*=" + value + "])");
                        messages.forEach(message => message.classList.add("hide"));
                    }

                    {$trigger_chat}
                </script>
CHAT;
        } else {
            $type = $_SESSION["type"];

            if ($type == "owner") {
                $chat = get_alert("info", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Oops! Parece que no has conectado con ningun paseador. Asegurate de haber completado tu <a href='/perrinatas/profile.php'>perfil</a> para <a href='/perrinatas/dashboard.php'>conectar con paseadores</a>.");
            } else {
                $chat = get_alert("info", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Oops! Parece que no has conectado con ningun perrito. Asegurate de haber completado tu <a href='/perrinatas/profile.php'>perfil</a> para <a href='/perrinatas/dashboard.php'>conectar con perritos</a>.");
            }
        }

        return $chat;
    }

    function get_contact($data) {
        global $curr_dog;

        $id_user = $data["id"];
        $id_match = $data["id_match"];
        $photo = $data["photo"];
        $name = $data["name"];
        $content = $data["message"];
        $datetime = $data["datetime"];
        $id_contact = strtolower("$id_match-$name");

        if (!$content && !$datetime) {
            $datetime = $data["datetime_match"];
            $content = "¡Te has conectado con $name, ya pueden charlar!";
        }

        $id_dog = ($curr_dog > 0) ? "&id=$curr_dog" : "";

        $datetime = date("h:i A | j M", strtotime($datetime));

        $contact = <<<CONTACT
            <li id="{$id_contact}" class="contact p-2 border-bottom row">
                <div class="col-flex align-self-center">
                    <a href="?id_user={$id_user}{$id_dog}" class="btn btn-light" type="button">
                        <img class="avatar d-flex align-self-center me-3" src="img/{$photo}" alt="avatar">
                    </a>
                </div>
                <div class="col">
                    <button class="btn btn-block btn-light d-flex justify-content-between" onclick="change_tab('messages');filter_messages({$id_match});scroll_bottom('scrolleable');return false;">
                        <div class="align-self-center">
                            <div class="text-left align-self-center">
                                <p class="fw-bold mb-0">{$name}</p>
                                <p class="small text-muted">{$content}</p>
                            </div>
                        </div>
                        <div class="align-self-center">
                            <p class="small text-muted mb-1">{$datetime}
                                <i class="fa-solid fa-arrow-right"></i>
                            </p>
                            <!-- <span class="badge bg-danger rounded-pill float-end">3</span> -->
                        </div>
                    </button>
                </div>
            </li>
CONTACT;

        return $contact;
    }

    function get_connection_message($data) {
        $id_match = $data["id_match"];
        $name = $data["name"];
        $content = "¡Te has conectado con $name, ya pueden charlar!";
        $datetime = $data["datetime_match"];
        $datetime = date("h:i A | j M", strtotime($datetime));

        $message = <<<MESSAGE
            <li id="message-{$id_match}-0" class="message d-flex flex-row justify-content-end">
                <div>
                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-success">{$content}</p>
                    <p class="small me-3 mb-3 rounded-3 text-muted">{$datetime}</p>
                </div>
            </li>
MESSAGE;

        return $message;
    }

    function get_message($data, $photo_user) {
        $id = $data["id"];
        $id_match = $data["id_match"];
        $name = $data["name"];
        $is_curr_user = $data["is_curr_user"];

        $photo = ($is_curr_user) ? $photo_user : $data["photo"];

        $content = $data["content"];
        $datetime = $data["datetime"];
        $datetime = date("h:i A | j M", strtotime($datetime));
        
        if ($is_curr_user) {
            $message = <<<MESSAGE
                <li id="message-{$id_match}-{$id}" class="message d-flex flex-row justify-content-end">
                    <div>
                        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">{$content}</p>
                        <p class="small me-3 mb-3 rounded-3 text-muted">{$datetime}</p>
                        </div>
                    <img class="avatar d-flex align-self-center me-3" src="img/{$photo}" alt="{$name}" />
                </li>
MESSAGE;
        } else {
            $message = <<<MESSAGE
                <li id="message-{$id_match}-{$id}" class="message d-flex flex-row justify-content-start">
                    <img class="avatar d-flex align-self-center me-3" src="img/{$photo}" alt="{$name}" />
                    <div>
                        <p class="small p-2 ms-3 mb-1 rounded-3">{$content}</p>
                        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">{$datetime}</p>
                    </div>
                </li>
MESSAGE;
        }

        return $message;
    }
?>