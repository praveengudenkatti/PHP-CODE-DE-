document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".danger").forEach(button => {

        button.addEventListener("click", event => {

            if (!confirm("Are you sure you want to delete this file?")) {
                event.preventDefault();
            }

        });

    });

});
