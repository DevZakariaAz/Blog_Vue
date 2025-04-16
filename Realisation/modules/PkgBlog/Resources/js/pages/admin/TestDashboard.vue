<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div :class="[
            'bg-gray-900 text-white transition-all duration-300 ease-in-out',
            sidebarOpen ? 'w-64' : 'w-20'
        ]">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-800">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                    <span :class="['ml-3 font-semibold text-xl', !sidebarOpen && 'hidden']">Insights</span>
                </div>
                <button @click="toggleSidebar" class="p-1 rounded-md hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 18l-6-6 6-6" v-if="sidebarOpen"></path>
                        <path d="M9 18l6-6-6-6" v-else></path>
                    </svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="mt-5 px-2">
                <div class="space-y-1">
                    <!-- Dashboard -->
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-md bg-gray-800 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span :class="{ 'hidden': !sidebarOpen }">Dashboard</span>
                    </a>

                    <!-- Articles -->
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span :class="{ 'hidden': !sidebarOpen }">Articles</span>
                    </a>

                    <!-- Categories -->
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"></path>
                            <path d="M3 12h18"></path>
                            <path d="M3 18h18"></path>
                        </svg>
                        <span :class="{ 'hidden': !sidebarOpen }">Categories</span>
                    </a>

                    <!-- Users -->
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span :class="{ 'hidden': !sidebarOpen }">Users</span>
                    </a>

                    <!-- Comments -->
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <span :class="{ 'hidden': !sidebarOpen }">Comments</span>
                    </a>

                    <!-- Analytics -->
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                        <span :class="{ 'hidden': !sidebarOpen }">Analytics</span>
                    </a>

                    <!-- Settings -->
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                            </path>
                        </svg>
                        <span :class="{ 'hidden': !sidebarOpen }">Settings</span>
                    </a>
                </div>
            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-0 w-full px-2 pb-5">
                <a href="#"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span :class="{ 'hidden': !sidebarOpen }">Logout</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <div class="relative">
                                <input type="text" placeholder="Search..."
                                    class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                <div class="absolute left-3 top-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </div>
                            </div>

                            <!-- Notifications -->
                            <button
                                class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <span class="sr-only">View notifications</span>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg>
                                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                                </div>
                            </button>

                            <!-- Profile Dropdown -->
                            <div class="relative" ref="profileDropdown">
                                <button @click="toggleProfileMenu"
                                    class="flex items-center space-x-3 focus:outline-none">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin User" />
                                    <div class="hidden md:block text-left">
                                        <span class="text-sm font-medium text-gray-900">Alex Morgan</span>
                                        <span class="text-xs text-gray-500 block">Administrator</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>

                                <!-- Profile Dropdown Menu -->
                                <div v-if="profileMenuOpen"
                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your
                                        Profile</a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign
                                        out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-400 text-sm">Total Articles</h2>
                                <p class="font-bold text-2xl text-gray-900">245</p>
                                <p class="text-green-500 text-sm flex items-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                        <polyline points="17 6 23 6 23 12"></polyline>
                                    </svg>
                                    12% increase
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-400 text-sm">Total Users</h2>
                                <p class="font-bold text-2xl text-gray-900">1,342</p>
                                <p class="text-green-500 text-sm flex items-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                        <polyline points="17 6 23 6 23 12"></polyline>
                                    </svg>
                                    8% increase
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-400 text-sm">Comments</h2>
                                <p class="font-bold text-2xl text-gray-900">3,721</p>
                                <p class="text-green-500 text-sm flex items-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                        <polyline points="17 6 23 6 23 12"></polyline>
                                    </svg>
                                    24% increase
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-400 text-sm">Avg. Time on Site</h2>
                                <p class="font-bold text-2xl text-gray-900">4m 23s</p>
                                <p class="text-red-500 text-sm flex items-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                        <polyline points="17 18 23 18 23 12"></polyline>
                                    </svg>
                                    3% decrease
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Articles & Traffic Chart -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Recent Articles -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="font-bold text-gray-800">Recent Articles</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Author</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Category</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(article, index) in recentArticles" :key="index">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ article.title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <img class="h-8 w-8 rounded-full" :src="article.author.avatar"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{
                                                        article.author.name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ article.category }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="[
                                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                article.status === 'Published' ? 'bg-green-100 text-green-800' :
                                                    article.status === 'Draft' ? 'bg-yellow-100 text-yellow-800' :
                                                        'bg-gray-100 text-gray-800'
                                            ]">
                                                {{ article.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ article.date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-3 border-t border-gray-200 bg-gray-50 text-right">
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">View All
                                Articles</a>
                        </div>
                    </div>

                    <!-- Traffic Chart -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="font-bold text-gray-800 mb-4">Traffic Overview</h2>
                        <div class="relative h-60">
                            <!-- Placeholder for chart -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-gray-500 mb-2">Chart visualization would appear here</p>
                                    <div class="h-40 w-full bg-gray-100 rounded-lg flex items-end justify-around px-2">
                                        <div class="w-6 bg-blue-500 rounded-t-md" style="height: 60%"></div>
                                        <div class="w-6 bg-blue-500 rounded-t-md" style="height: 80%"></div>
                                        <div class="w-6 bg-blue-500 rounded-t-md" style="height: 40%"></div>
                                        <div class="w-6 bg-blue-500 rounded-t-md" style="height: 70%"></div>
                                        <div class="w-6 bg-blue-500 rounded-t-md" style="height: 90%"></div>
                                        <div class="w-6 bg-blue-500 rounded-t-md" style="height: 50%"></div>
                                        <div class="w-6 bg-blue-500 rounded-t-md" style="height: 75%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Top Categories -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Activity -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="font-bold text-gray-800">Recent Activity</h2>
                        </div>
                        <div class="p-6">
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    <li v-for="(activity, index) in recentActivity" :key="index">
                                        <div class="relative pb-8">
                                            <span v-if="index !== recentActivity.length - 1"
                                                class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
                                                aria-hidden="true"></span>
                                            <div class="relative flex items-start space-x-3">
                                                <div class="relative">
                                                    <div :class="[
                                                        'h-10 w-10 rounded-full flex items-center justify-center ring-8 ring-white',
                                                        activity.type === 'article' ? 'bg-blue-500' :
                                                            activity.type === 'comment' ? 'bg-green-500' :
                                                                activity.type === 'user' ? 'bg-purple-500' : 'bg-gray-500'
                                                    ]">
                                                        <svg v-if="activity.type === 'article'"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path
                                                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                            </path>
                                                            <polyline points="14 2 14 8 20 8"></polyline>
                                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                                            <polyline points="10 9 9 9 8 9"></polyline>
                                                        </svg>
                                                        <svg v-else-if="activity.type === 'comment'"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path
                                                                d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                            </path>
                                                        </svg>
                                                        <svg v-else-if="activity.type === 'user'"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ activity.user }}
                                                        </div>
                                                        <p class="mt-0.5 text-sm text-gray-500">
                                                            {{ activity.time }}
                                                        </p>
                                                    </div>
                                                    <div class="mt-2 text-sm text-gray-700">
                                                        <p>{{ activity.action }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Top Categories -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="font-bold text-gray-800">Top Categories</h2>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-4">
                                <li v-for="(category, index) in topCategories" :key="index" class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full"
                                            :style="{ width: category.percentage + '%' }"></div>
                                    </div>
                                    <span class="ml-4 text-sm font-medium text-gray-900 w-32">{{ category.name }}</span>
                                    <span class="ml-auto text-sm font-medium text-gray-500">{{ category.count }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// Sidebar state
const sidebarOpen = ref(true);
const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

// Profile dropdown state
const profileMenuOpen = ref(false);
const profileDropdown = ref(null);

const toggleProfileMenu = () => {
    profileMenuOpen.value = !profileMenuOpen.value;
};

// Close profile menu when clicking outside
const handleClickOutside = (event) => {
    if (profileDropdown.value && !profileDropdown.value.contains(event.target)) {
        profileMenuOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

// Recent articles data
const recentArticles = ref([
    {
        title: 'The Future of Sustainable Technology',
        author: {
            name: 'Alex Morgan',
            avatar: 'https://randomuser.me/api/portraits/women/44.jpg'
        },
        category: 'Technology',
        status: 'Published',
        date: 'Nov 15, 2023'
    },
    {
        title: 'How AI is Optimizing Energy Consumption',
        author: {
            name: 'Jamie Chen',
            avatar: 'https://randomuser.me/api/portraits/men/32.jpg'
        },
        category: 'Technology',
        status: 'Published',
        date: 'Nov 10, 2023'
    },
    {
        title: 'The Art of Modern Architecture',
        author: {
            name: 'Taylor Reed',
            avatar: 'https://randomuser.me/api/portraits/women/67.jpg'
        },
        category: 'Design',
        status: 'Draft',
        date: 'Nov 5, 2023'
    },
    {
        title: 'Global Cuisine: A Journey Through Flavors',
        author: {
            name: 'Sam Johnson',
            avatar: 'https://randomuser.me/api/portraits/men/22.jpg'
        },
        category: 'Wellness',
        status: 'Published',
        date: 'Oct 28, 2023'
    },
    {
        title: 'The Evolution of Remote Work',
        author: {
            name: 'Jordan Smith',
            avatar: 'https://randomuser.me/api/portraits/women/17.jpg'
        },
        category: 'Business',
        status: 'Review',
        date: 'Oct 20, 2023'
    }
]);

// Recent activity data
const recentActivity = ref([
    {
        type: 'article',
        user: 'Alex Morgan',
        time: '2 hours ago',
        action: 'Published a new article "The Future of Sustainable Technology"'
    },
    {
        type: 'comment',
        user: 'Jamie Chen',
        time: '4 hours ago',
        action: 'Commented on "How AI is Optimizing Energy Consumption"'
    },
    {
        type: 'user',
        user: 'System',
        time: '6 hours ago',
        action: '15 new users registered'
    },
    {
        type: 'article',
        user: 'Taylor Reed',
        time: '1 day ago',
        action: 'Updated article "The Art of Modern Architecture"'
    },
    {
        type: 'comment',
        user: 'Sam Johnson',
        time: '2 days ago',
        action: 'Replied to a comment on "Global Cuisine: A Journey Through Flavors"'
    }
]);

// Top categories data
const topCategories = ref([
    { name: 'Technology', count: 87, percentage: 85 },
    { name: 'Business', count: 65, percentage: 65 },
    { name: 'Design', count: 42, percentage: 42 },
    { name: 'Wellness', count: 38, percentage: 38 },
    { name: 'Environment', count: 25, percentage: 25 }
]);
</script>