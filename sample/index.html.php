<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Just ask | Ondine</title>

		<!--<link rel="stylesheet" href="css/main.min.css" media="screen">-->
    </head>
    <body>
        <form id="form">
            <input type="text" id="question" placeholder="Just ask..." autocomplete="off" />
            <!--<input type="submit" value="" />-->
        </form>
        <div id="response"></div>

        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script type="text/javascript">
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
        </script>
    </body>
</html>