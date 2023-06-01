<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Short link') }}
        </h2>
        <a href="{{ route('post.name') }}">
            <button class="bg-primary px-4">If you want to share your profile on social midea Go to next page.</button>
        </a>
     
    </x-slot>

    <div class="container">
        <div class="py-12">
        
            <form method="POST" action="{{ route('generate.shorten.link.post') }}">
                @csrf
                <div class="flex justify-between">
                    <div class=" mb-3">
                        <input type="text" name="link" class="w-12 mb-2" placeholder="Enter URL"
                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="ml-8">
                            <button class="btn bg-success" type="submit">Generate Short Link</button>
                        </div>
                    </div>
                </div>
            </form>


            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Public Link</th>
                        <th>Original URL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shortLinks as $shortLink)
                        <tr>
                            <td><a href="{{ route('shorten.link', $shortLink->code) }}"
                                    target="_blank">{{ route('shorten.link', $shortLink->code) }}</a></td>
                            <td>{{ $shortLink->link }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
