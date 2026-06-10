const urlBase =
    "https://tncis4004.xyz/LAMPAPI";

function doRegister()
{
    let payload =
    {
        firstName:
            document.getElementById(
                "firstName"
            ).value,

        lastName:
            document.getElementById(
                "lastName"
            ).value,

        username:
            document.getElementById(
                "username"
            ).value,

        password:
            document.getElementById(
                "password"
            ).value
    };

    fetch(urlBase + "/Register.php",
    {
        method: "POST",

        headers:
        {
            "Content-Type":
                "application/json"
        },

        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data =>
    {
        if (data.success)
        {
            document.getElementById("registerResult").innerHTML =
                "Account Created Successfully";
        }
        else
        {
            document.getElementById("registerResult").innerHTML =
                data.message;
        }
    })
    .catch(error =>
    {
        console.log(error);
    });
}
