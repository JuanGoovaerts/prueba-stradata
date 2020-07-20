@extends('layouts.app')

@section('content')
    <div x-data="publicPersons()" class="mt-6 bg-white shadow overflow-hidden rounded-md">
        <div class="bg-white px-4 pb-5 pt-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Candidates
            </h3>
        </div>
        <div class="px-4 pt-5 pb-3 sm:px-6">
            <div>
                <label for="filter" class="sr-only">Search candidates</label>
                <div class="flex rounded-md shadow-sm">
                    <div class="relative flex-grow focus-within:z-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input
                            x-model="name"
                            id="filter"
                            type="search"
                            class="search-input rounded-l-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150"
                            :class="{
                                'border-red-500': hasError('name')
                            }"
                            placeholder="John Doe">
                    </div>
                    <div class="w-32 relative focus-within:z-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input x-model="rating"
                               id="rating"
                               class="search-input placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150"
                               :class="{
                                'border-red-500': hasError('rating')
                                }"
                               placeholder="90">
                    </div>
                    <button @click="search()"
                            class="-ml-px relative flex items-center px-3 py-2 rounded-r-md border border-gray-300 text-sm leading-5 bg-gray-50 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 transition ease-in-out duration-150">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2">Filter</span>
                    </button>
                </div>
                <p class="mt-2 text-sm text-red-600" id="email-error" x-show="hasError('name')"
                   x-text="getError('name')"></p>
                <p class="mt-2 text-sm text-red-600" id="email-error" x-show="hasError('rating')"
                   x-text="getError('rating')"></p>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Lugar
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <template x-for="(person, index) in persons" :key="person.id">
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full"
                                                :src="`https://i.pravatar.cc/150?p=${person.id}`"
                                                 alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm leading-5 font-medium text-gray-900" x-text="person.nombre"></div>
                                            <div class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <span
                                                    x-text="person.raking.toFixed(2)"
                                                    >
                                                </span>%
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500" x-text="person.tipo_cargo">

                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-900" x-text="person.municipio"></div>
                                    <div class="text-sm leading-5 text-gray-500" x-text="person.departamento">Human Resources</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                        </template>
                        <tr class="bg-white" x-show="loading">
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                Cargando...
                            </td>
                        </tr>
                        <tr class="bg-white" x-show="!persons.length && !loading">
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                No se encontraron resultados. Filtra con los campos arriba
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            function publicPersons() {
                return {
                    persons: [],
                    name: '',
                    rating: 80,
                    errors: {},
                    loading: false,
                    search() {
                        this.loading = true
                        this.clearErrors()
                        axios.post('/search_name', {
                            name: this.name,
                            rating: this.rating
                        }).then(({data}) => {
                            this.persons = data.persons
                            console.log(data);
                        }).catch((error) => {
                            this.errors = error.response.data.errors
                        }).finally(() => this.loading = false)
                    },
                    hasError(field) {
                        return this.errors.hasOwnProperty(field);
                    },
                    getError(field) {
                        if (this.errors[field]) {
                            return this.errors[field][0];
                        }
                    },
                    clearErrors() {
                        this.errors = {}
                    }
                }
            }
        </script>
    @endpush
@endsection
