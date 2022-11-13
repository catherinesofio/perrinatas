<?php
    function get_modal() {
        $modal = <<<MODAL
            <div id="modal"class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </h5>
            
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="hide_modal();">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
            
                        <div class="modal-body">
                        </div>
            
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                function add_close_event() {
                    $("#modal").on("hidden.bs.modal", function () {
                        setTimeout(() => {
                            const urlParams = new URLSearchParams(window.location.search);
    
                            let modal = document.querySelector("#modal");
                            let params = modal.getAttribute("url_params");
                            params = JSON.parse(params);
        
                            params.forEach(param => {
                                urlParams.delete(param);
                            });
    
                            window.location.search = urlParams;
                        }, 1);
                    });
                }

                function show_modal(type, title, body, footer = "", params = []) {
                    let modal = document.querySelector("#modal");
                    let modal_title = document.querySelector(".modal-title");
                    let modal_body = document.querySelector(".modal-body");
                    let modal_footer = document.querySelector(".modal-footer");
                
                    modal_title.setAttribute("class", "modal-title text-" + type);

                    modal.setAttribute("url_params", JSON.stringify(params));
                    modal_title.innerHTML = title;
                    modal_body.innerHTML = body;
                    modal_footer.innerHTML = footer;

                    $("#modal").modal("show");
                }
                
                function hide_modal() {
                    $("#modal").modal({ show: false});
                }
                
                document.addEventListener("DOMContentLoaded", add_close_event);
            </script>
MODAL;

        return $modal;
    }
    
    function show_modal($type, $title, $body, $footer = "", $params = "[]") {
        $modal = <<<MODAL
            <script type="text/javascript">
                show_modal("{$type}", "{$title}", `{$body}`, `{$footer}`, {$params});
            </script>
MODAL;

        echo($modal);
    }
?>