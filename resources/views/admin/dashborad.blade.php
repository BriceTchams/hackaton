<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Dark Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Style pour masquer la flèche par défaut de l'accordéon et utiliser la nôtre */
        details summary::-webkit-details-marker { display: none; }
        details[open] .chevron { transform: rotate(180deg); }
    </style>
</head>
<body class="h-full text-gray-200">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-gray-800 border-r border-gray-700 flex flex-col">
            <div class="p-6">
                <span class="text-2xl font-bold text-indigo-500 uppercase tracking-widest">Admin<span class="text-white">Panel</span></span>
            </div>

            <nav class="flex-1 px-4 space-y-2 overflow-y-auto custom-scrollbar">
                
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors bg-gray-700/50 text-indigo-400">
                    <i class="fas fa-chart-line w-6 text-center"></i>
                    <span class="ml-3 font-medium">Tableau de bord</span>
                </a>

                <details class="group">
                    <summary class="flex items-center justify-between p-3 text-gray-300 hover:bg-gray-700 rounded-lg cursor-pointer list-none transition-all">
                        <div class="flex items-center">
                            <i class="fas fa-wallet w-6 text-center"></i>
                            <span class="ml-3 font-medium">Portefeuille</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs chevron transition-transform duration-200"></i>
                    </summary>
                    <div class="pl-12 py-2 space-y-1">
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Transactions</a>
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Retraits</a>
                        {{-- <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Paramètres</a> --}}
                    </div>
                </details>

                <details class="group">
                    <summary class="flex items-center justify-between p-3 text-gray-300 hover:bg-gray-700 rounded-lg cursor-pointer list-none transition-all">
                        <div class="flex items-center">
                            <i class="fas fa-id-card w-6 text-center"></i>
                            <span class="ml-3 font-medium">Chauffeurs</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs chevron transition-transform duration-200"></i>
                    </summary>
                    <div class="pl-12 py-2 space-y-1">
                        <a href="{{ route('driver') }}" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Liste des chauffeurs</a>
                        {{-- <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">En attente</a> --}}
                        <a href="" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Documents</a>
                    </div>
                </details>

                <details class="group">
                    <summary class="flex items-center justify-between p-3 text-gray-300 hover:bg-gray-700 rounded-lg cursor-pointer list-none transition-all">
                        <div class="flex items-center">
                            <i class="fas fa-users w-6 text-center"></i>
                            <span class="ml-3 font-medium">Passagers</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs chevron transition-transform duration-200"></i>
                    </summary>
                    <div class="pl-12 py-2 space-y-1">
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Tous les clients</a>
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Avis & Notes</a>
                    </div>
                </details>

                <details class="group">
                    <summary class="flex items-center justify-between p-3 text-gray-300 hover:bg-gray-700 rounded-lg cursor-pointer list-none transition-all">
                        <div class="flex items-center">
                            <i class="fas fa-route w-6 text-center"></i>
                            <span class="ml-3 font-medium">Courses</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs chevron transition-transform duration-200"></i>
                    </summary>
                    <div class="pl-12 py-2 space-y-1">
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">En cours</a>
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Historique</a>
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white transition-colors">Annulées</a>
                    </div>
                </details>

            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="get" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 text-red-400 hover:bg-red-900/20 rounded-lg transition-colors group">
                        <i class="fas fa-sign-out-alt w-6 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="ml-3 font-medium">Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">
            
            <header class="h-16 bg-gray-800 border-b border-gray-700 flex items-center justify-between px-8">
                <h1 class="text-xl font-semibold">Vue d'ensemble</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-400 hover:text-white px-2 relative">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div class="flex items-center space-x-2 border-l border-gray-700 pl-4">
                        <span class="text-sm font-medium">Admin</span>
                        <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs">AD</div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-sm">
                        <p class="text-gray-400 text-sm font-medium">Revenus Totaux</p>
                        <h3 class="text-2xl font-bold mt-1">12450fcfa</h3>
                        <p class="text-green-400 text-xs mt-2"><i class="fas fa-arrow-up"></i> +12% ce mois</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-sm">
                        <p class="text-gray-400 text-sm font-medium">Courses Actives</p>
                        <h3 class="text-2xl font-bold mt-1">45</h3>
                        <p class="text-indigo-400 text-xs mt-2">En temps réel</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-sm">
                        <p class="text-gray-400 text-sm font-medium">Chauffeurs en ligne</p>
                        <h3 class="text-2xl font-bold mt-1">128</h3>
                        <p class="text-green-400 text-xs mt-2"><i class="fas fa-circle text-[8px] animate-pulse"></i> Connectés</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-sm">
                        <p class="text-gray-400 text-sm font-medium">Nouveaux Passagers</p>
                        <h3 class="text-2xl font-bold mt-1">1,204</h3>
                        <p class="text-gray-500 text-xs mt-2">Total cumulé</p>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-lg">
                    <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                        <h3 class="font-bold text-lg">Dernières Courses</h3>
                        <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm transition-colors">Voir tout</button>
                    </div>
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-700/50">
                            <tr>
                                <th class="p-4 font-semibold text-gray-300 text-sm uppercase">ID</th>
                                <th class="p-4 font-semibold text-gray-300 text-sm uppercase">Passager</th>
                                <th class="p-4 font-semibold text-gray-300 text-sm uppercase">Chauffeur</th>
                                <th class="p-4 font-semibold text-gray-300 text-sm uppercase">Statut</th>
                                <th class="p-4 font-semibold text-gray-300 text-sm uppercase text-right">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="p-4 text-sm">#TR-5642</td>
                                <td class="p-4 text-sm font-medium">Jean Dupont</td>
                                <td class="p-4 text-sm">Marc Ahmed</td>
                                <td class="p-4"><span class="px-2 py-1 bg-green-500/20 text-green-400 text-[10px] font-bold rounded-full uppercase">Terminé</span></td>
                                <td class="p-4 text-sm text-right font-mono">2000 Fcfa</td>
                            </tr>
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="p-4 text-sm">#TR-5643</td>
                                <td class="p-4 text-sm font-medium">Sarah L.</td>
                                <td class="p-4 text-sm">Kevin S.</td>
                                <td class="p-4"><span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 text-[10px] font-bold rounded-full uppercase">En cours</span></td>
                                <td class="p-4 text-sm text-right font-mono">1800Fcfa</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>

</body>
</html>