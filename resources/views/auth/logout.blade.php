<x-guest-layout>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('ログイン画面へ') }}
            </a>
        
        
        
    </form>
</x-guest-layout>