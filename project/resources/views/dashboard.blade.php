<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-modal id="editModal" name="editReport" >
        <div style="width:100%;padding:10%">
            <form>
                <h7 id="customer_h" style="font-size: xx-large;font-weight: bolder;"></h7>
                <hr/>
                <p  class="formInput">Appoitment date</p>
                <p>
                    <input id="ad" style="width:100%" type="datetime-local"  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" ></input>
                </p>
                <p class="formInput">Report text</p>
                <p>
                    <textarea style="width:100%;min-height:213px"  id="report_text"  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" ></textarea>
                </p>
                @if(\Auth::user()->hasRole('manager'))
                <p  class="formInput">Assignment</p>
                <p>
                    <select id="as_select"  style="width:100%"  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </p>
                @endif
                <p  class="formInput">
                    <button class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" id="cancel_report">Cancel</button>
                    <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" style="float:right" id="update_report">Save</button>
                </p>
            </form>
        </div>
    </x-modal>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <p class="customFilter">
                    <input type="checkbox" id="past_dates">&nbsp; Show Past dates</input>
                </p>
            </div>
                <div class="p-6 text-gray-900">
                       
                        <table id="basic">
                            <thead>
                                <tr>
                                    <th>Customer name</th>
                                    <th>Appointment date</th>
                                    <th>Number of characters in report text</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                                                
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
