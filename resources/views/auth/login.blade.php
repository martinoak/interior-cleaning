<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="title" content="Čištění interiéru Kondrac">
    <meta name="description" content="Vaše auto vyčistíme rychle, levně a kvalitně! Čištíme osobní automobily a používáme šetrné, ale účinné prostředky, aby se Vaše auto blyštilo.">
    <title>Čištění interiéru Kondrac</title>

    <!--====== Favicon Icon ======-->
    <link
        rel="shortcut icon"
        href="{{ asset('images/logo/logo.png') }}"
    />

    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>

</head>
<body>

<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="/images/logo/logo.png" alt="logo">
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form class="space-y-4 md:space-y-6" action="/!/login">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-white bg-gray-700 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="@cisteni-kondrac.cz" placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Heslo</label>
                        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-white bg-gray-700 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                    </div>
                    <div class="w-1/2 mx-auto">
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Přihlásit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>
