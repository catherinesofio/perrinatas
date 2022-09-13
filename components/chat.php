<!DOCTYPE html>
<html lang="es">
    <body>
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
                                    <button id="contacts-tab" class="nav-link active" data-toggle="tab" data-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="true" onclick="scroll_top('scrolleable');">Contactos</button>
                                </li>

                                <!-- Messages Tab Button -->
                                <li class="nav-item" role="presentation">
                                    <button id="messages-tab" class="nav-link" data-toggle="tab" data-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false" disabled>Chat</button>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Tab Content -->
                        <form id="scrolleable" class="card-body custom-height">
                            <div id="myTabContent" class="tab-content">
                                <!-- Contacts Tab -->
                                <div id="contacts" class="tab-pane fade show active" role="tabpanel" aria-labelledby="contacts-tab">
                                    <!-- Search Bar -->
                                    <form
                                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar contacto..." aria-label="Search" aria-describedby="basic-addon2">
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
                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=1" class="d-flex justify-content-between" onclick="change_tab('messages');scroll_bottom('scrolleable');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Marie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=2" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=3" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=4" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=5" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=6" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=7" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=8" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=9" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="p-2 border-bottom">
                                                <a href="?chat_id=10" class="d-flex justify-content-between" onclick="change_tab('messages');return false;">
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar">
                                                            <span class="badge bg-success badge-dot"></span>
                                                        </div>
                                                        
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Jamie Horwitz</p>
                                                            <p class="small text-muted">Hello, Are you there?</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Just now</p>
                                                        <span class="badge bg-danger rounded-pill float-end">3</span>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- Messages Tab -->
                                <div id="messages" class="tab-pane fade" role="tabpanel" aria-labelledby="messages-tab">
                                    <!-- Messages -->
                                    <ul class="pt-3 pe-3 d-inline-block w-100" data-mdb-perfect-scrollbar="true">
                                        <li class="d-flex flex-row justify-content-start">
                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar d-flex align-self-center me-3 1">
                                            <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3">Lorem ipsum
                                                    dolor
                                                    sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                                    dolore
                                                    magna aliqua.</p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                            </div>
                                        </li>

                                        <li class="d-flex flex-row justify-content-end">
                                            <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Ut enim ad minim veniam,
                                                    quis
                                                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                                </div>
                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar d-flex align-self-center me-3 1">
                                        </li>

                                        <li class="d-flex flex-row justify-content-start">
                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar d-flex align-self-center me-3 1">
                                            <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3">Duis aute
                                                    irure
                                                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                                </p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                            </div>
                                        </li>

                                        <li class="d-flex flex-row justify-content-end">
                                            <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Excepteur sint occaecat
                                                    cupidatat
                                                    non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                            </div>
                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar d-flex align-self-center me-3 1">
                                        </li>

                                        <li class="d-flex flex-row justify-content-start">
                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar d-flex align-self-center me-3 1">
                                            <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3">Sed ut
                                                    perspiciatis
                                                    unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam
                                                    rem
                                                    aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
                                                    dicta
                                                    sunt explicabo.</p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                            </div>
                                        </li>

                                        <li class="d-flex flex-row justify-content-end">
                                            <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Nemo enim ipsam
                                                    voluptatem quia
                                                    voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos
                                                    qui
                                                    ratione voluptatem sequi nesciunt.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                            </div>
                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar d-flex align-self-center me-3 1">
                                        </li>

                                        <li class="d-flex flex-row justify-content-start">
                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar d-flex align-self-center me-3 1">
                                            <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Neque porro
                                                    quisquam
                                                    est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non
                                                    numquam
                                                    eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                            </div>
                                        </li>

                                        <li class="d-flex flex-row justify-content-end">
                                            <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Ut enim ad minima veniam,
                                                    quis
                                                    nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea
                                                    commodi
                                                    consequatur?</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                            </div>
                                            <img class="avatar d-flex align-self-center me-3" src="img/default-person.jpg" alt="avatar 1">
                                        </li>
                                    </ul>

                                    <!-- Text Box -->
                                    <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                        <input class="form-control form-control-lg" type="text" placeholder="Type message" />
                                        
                                        <a class="ms-3" href="#!">
                                            <i class="fas fa-paper-plane"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>