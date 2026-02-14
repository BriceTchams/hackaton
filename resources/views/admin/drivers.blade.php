<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Chauffeurs</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        .dataTables_wrapper .dataTables_length select, 
        .dataTables_wrapper .dataTables_filter input {
            background-color: #374151 !important;
            border: 1px solid #4b5563 !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 5px 12px !important;
            outline: none !important;
        }
        .dataTables_wrapper .dataTables_info, 
        .dataTables_wrapper .dataTables_paginate {
            color: #9ca3af !important;
            margin-top: 15px !important;
        }
        table.dataTable { border-collapse: collapse !important; border: none !important; margin-top: 20px !important; }
        table.dataTable thead th { border-bottom: 1px solid #374151 !important; background-color: #1f2937 !important; color: #9ca3af !important; font-size: 0.75rem; text-transform: uppercase; }
        table.dataTable td { border-bottom: 1px solid #374151 !important; padding: 12px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4f46e5 !important; border: none !important; color: white !important; border-radius: 6px !important;
        }
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

            <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
                
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-chart-line w-6 text-center"></i>
                    <span class="ml-3 font-medium">Tableau de bord</span>
                </a>

                <details class="group">
                    <summary class="flex items-center justify-between p-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg cursor-pointer list-none transition-all">
                        <div class="flex items-center">
                            <i class="fas fa-wallet w-6 text-center"></i>
                            <span class="ml-3 font-medium">Portefeuille</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs chevron transition-transform duration-200"></i>
                    </summary>
                    <div class="pl-12 py-2 space-y-1">
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white">Transactions</a>
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white">Retraits</a>
                    </div>
                </details>

                <details class="group" open>
                    <summary class="flex items-center justify-between p-3 text-indigo-400 bg-gray-700/50 rounded-lg cursor-pointer list-none transition-all">
                        <div class="flex items-center">
                            <i class="fas fa-id-card w-6 text-center"></i>
                            <span class="ml-3 font-medium">Chauffeurs</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs chevron transition-transform duration-200"></i>
                    </summary>
                    <div class="pl-12 py-2 space-y-1">
                        <a href="{{ route('driver') }}" class="block p-2 text-sm text-white font-semibold italic">Liste des chauffeurs</a>
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white">Documents</a> 
                    </div>
                </details>

                <details class="group">
                    <summary class="flex items-center justify-between p-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg cursor-pointer list-none transition-all">
                        <div class="flex items-center">
                            <i class="fas fa-users w-6 text-center"></i>
                            <span class="ml-3 font-medium">Passagers</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs chevron transition-transform duration-200"></i>
                    </summary>
                    <div class="pl-12 py-2 space-y-1">
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white">Tous les passagers</a>
                    </div>
                </details>

                <details class="group">
                    <summary class="flex items-center justify-between p-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg cursor-pointer list-none transition-all">
                        <div class="flex items-center">
                            <i class="fas fa-route w-6 text-center"></i>
                            <span class="ml-3 font-medium">Courses</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs chevron transition-transform duration-200"></i>
                    </summary>
                    <div class="pl-12 py-2 space-y-1">
                        <a href="#" class="block p-2 text-sm text-gray-400 hover:text-white">En cours</a>
                    </div>
                </details>

            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
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
                <h1 class="text-xl font-semibold text-indigo-400 italic">Chauffeurs</h1>
                <div class="flex items-center space-x-4 italic text-sm text-gray-400">
                    <span>Admin</span>
                    <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold">AD</div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 shadow-2xl">
                    <table id="driversTable" class="w-full text-left">
                        <thead>
                            <tr>                               
                                
                                <th>numeroPermisConduire</th>

                                <th>Email</th>
                                <th>nom</th>
                                <th>Ville</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- {{ dd($drivers) }} --}}
                        <tbody class="divide-y divide-gray-700">
                            @foreach($drivers as $driver)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td>
                                    {{-- <div class="font-bold text-white">{{ $driver->name }} {{ $driver->prenom }}</div> --}}
                                    <div class="text-xs text-gray-400">{{ $driver->numero_permis }}</div>
                                </td>

                                <td class="text-sm text-gray-300 font-mono">
                                    {{ $driver->email }}

                                <td class="text-sm text-gray-300 font-mono">
                                    {{ $driver->name?? 'N/A' }}
                                </td>
                                <td class="text-sm text-gray-300">{{ $driver->ville ?? 'N/A' }}</td>
                                <td>
                                    @if($driver->statut_validation === 'En attente')
                                        <span class="px-2 py-1 bg-yellow-500/10 text-yellow-500 text-[10px] font-bold rounded-full border border-yellow-500/20 uppercase tracking-tighter">En attente</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] font-bold rounded-full border border-green-500/20 uppercase tracking-tighter">Validé</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- {{ dd($drivers) }} --}}
                                    @if($driver->statut_validation === 'En attente')
                                        <form action="{{ route('driver.verify') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_chauffeur" value="{{ $driver->id_user }}">
                                            <button type="submit" class="bg-green-600 hover:bg-green-500 text-white text-[10px] px-3 py-1.5 rounded-lg transition-all font-bold">
                                                VALIDER
                                            </button>
                                        </form>
                                    @else
                                        <button class="text-indigo-400 hover:text-white text-xs border border-indigo-400 px-3 py-1 rounded-lg">Détails</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            $('#driversTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
                },
                "pageLength": 10,
                "ordering": true,
                "responsive": true
            });
        });
    </script>
</body>
</html>