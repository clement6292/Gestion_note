<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Créée</title>
    <style>
        /* Ajoutez Tailwind CSS ici via un CDN ou vous pouvez utiliser des styles en ligne */
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Bonjour,</h1>
        <p class="text-gray-700 mb-2">Vous avez créé une nouvelle note intitulée : <strong class="text-blue-500">{{ $note->title }}</strong>.</p>
        <p class="text-gray-700 mb-4">Contenu de la note :</p>
        <div class="bg-gray-50 p-4 border border-gray-300 rounded-lg mb-4">
            <p class="text-gray-800">{{ $note->content }}</p>
        </div>
        <p class="text-gray-700">Merci d'utiliser notre application !</p>
        <footer class="bg-gray-100 text-center py-6">
            <p class="text-gray-700 mb-2">
                Créé avec 💻 et ❤️ par 
                <a href="#" class="text-blue-500 font-bold hover:underline">
                    @Clément ABK (meilleur codeur 💎🚀)
                </a>
            </p>
            <p class="text-gray-500 text-sm">
                Pour des solutions sur mesure et innovantes, faites confiance à l'excellence !
            </p>
        </footer>
    </div>
</body>
</html>