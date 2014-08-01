(
    function ()
    {
        var NO_MOD_MATCHING,
            form,
            input,
            response;

        NO_MOD_MATCHING = "NoModMatching";

        form = $("#form");

        input = $("#question");

        response = $("#response");

        function ask(question)
        {
            if (!question || question.length == 0)
            {
                alert("You need to ask something.");
            }

            $.ajax(
                {
                    url: "api/v1/ask.php",
                    type: "POST",
                    dataType: "JSON",
                    data: { q: question }
                }
            )
                .done(
                function (response)
                {
                    input.val("");

                    if (response && response.content)
                    {
                        if (response.content == NO_MOD_MATCHING)
                        {
                            alert("Sorry, no answer has been found...");
                        }
                        else
                        {
                            alert(response.content);
                        }
                    }

                }
            )
                .fail(
                function (jqXHR, textStatus)
                {
                    console.log(jqXHR);
                    console.log(textStatus);
                }
            );
        }

        function onsubmit(e)
        {
            ask(input.val());

            if (e.preventDefault)
            {
                e.preventDefault();
            }
            else if (e.stopPropagation)
            {
                e.stopPropagation();
            }
        }

        form.bind("submit", onsubmit);

    }
)()