<!-- welcome.blade.php basic UI placeholder -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DealSpot</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">DealSpot</h1>
        <nav class="space-x-4">
            <a href="#" class="text-gray-700 hover:text-black">Home</a>
            <a href="#" class="text-gray-700 hover:text-black">Businesses</a>
            <a href="#" class="text-gray-700 hover:text-black">Categories</a>
        </nav>
    </header>

    <section class="max-w-5xl mx-auto mt-12 text-center">
        <h2 class="text-4xl font-bold mb-4">Find The Best Local Deals</h2>
        <p class="text-gray-600 mb-8">Discover businesses, discounts, and services near you.</p>
        <a href="/businesses/create" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Add Your Business</a>
    </section>

    <footer class="text-center text-gray-600 mt-16 py-6">
        © 2025 DealSpot. All rights reserved.
    </footer>
</body>
</html>
