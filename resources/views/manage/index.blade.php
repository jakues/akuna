<!DOCTYPE html>
<html lang="en" class="bg-slate-50">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-c4a42d02.css') }}">
    <title>manage - dashboard</title>
</head>

<body class="bg-slate-50" data-theme="pastel">
@include('etc.navbar')
{{--stats--}}
<div class="grid grid-cols-1 gap-4 px-4 mt-8 sm:grid-cols-4 sm:px-8">
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-green-400">
            <svg class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M20 10L4 10L9.5 4" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"></path>
                    <path d="M4 14L20 14L14.5 20" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"></path>
                </g>
            </svg>
        </div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Total Transaction</h3>
            <p id="total_tx" class="text-3xl">Loading...</p>
        </div>
    </div>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-blue-400">
            <svg class="h-12 w-12 text-white" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier"><title></title>
                    <g fill="none" fill-rule="evenodd" id="页面-1" stroke="none" stroke-width="1">
                        <g id="导航图标" transform="translate(-325.000000, -80.000000)">
                            <g id="编组" transform="translate(325.000000, 80.000000)">
                                <polygon fill="#FFFFFF" fill-opacity="0.01" fill-rule="nonzero" id="路径"
                                         points="24 0 0 0 0 24 24 24"></polygon>
                                <polygon id="路径" points="22 7 12 2 2 7 2 17 12 22 22 17" stroke="#ffffff"
                                         stroke-linejoin="round" stroke-width="1.5"></polygon>
                                <line id="路径" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="1.5" x1="2" x2="12" y1="7" y2="12"></line>
                                <line id="路径" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="1.5" x1="12" x2="12" y1="22" y2="12"></line>
                                <line id="路径" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="1.5" x1="22" x2="12" y1="7" y2="12"></line>
                                <line id="路径" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="1.5" x1="17" x2="7" y1="4.5" y2="9.5"></line>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Total Product</h3>
            <p id="total_product" class="text-3xl">Loading...</p>
        </div>
    </div>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-indigo-400">
            <svg class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z"
                        stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
        </div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Total Members</h3>
            <p id="total_member" class="text-3xl">Loading...</p>
        </div>
    </div>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-red-400">
            <svg class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z"
                          fill="#ffffff"></path>
                    <path
                        d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z"
                        fill="#ffffff"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z"
                          fill="#ffffff"></path>
                </g>
            </svg>
        </div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider"><span class="text-neutral-focus">@akunaindonesia</span> Followers</h3>
            <p id="ig_followers" class="text-3xl">Loading...</p>
        </div>
    </div>
</div>
{{--end stats--}}

{{--system stats--}}
<div class="grid grid-cols-1 gap-4 px-4 mt-8 sm:grid-cols-4 sm:px-8">
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-orange-400">
            <svg class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M4 18V6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M20 6V18" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                    <path
                        d="M12 10C16.4183 10 20 8.20914 20 6C20 3.79086 16.4183 2 12 2C7.58172 2 4 3.79086 4 6C4 8.20914 7.58172 10 12 10Z"
                        stroke="#ffffff" stroke-width="1.5"></path>
                    <path d="M20 12C20 14.2091 16.4183 16 12 16C7.58172 16 4 14.2091 4 12" stroke="#ffffff"
                          stroke-width="1.5"></path>
                    <path d="M20 18C20 20.2091 16.4183 22 12 22C7.58172 22 4 20.2091 4 18" stroke="#ffffff"
                          stroke-width="1.5"></path>
                </g>
            </svg>
        </div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Database Status</h3>
            <p class="db_health text-3xl">Loading...</p>
        </div>
    </div>
</div>
{{--end system stats--}}
{{-- script --}}
@include('etc.requirements')
<script src="{{ asset('build/assets/dashboard-1f26ce54.js') }}"></script>
{{-- script --}}
</body>

</html>
