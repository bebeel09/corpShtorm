<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    <div class="ml-auto mr-2">
        <div class="search">
            <input class="searchInput" type="text" wire:model="searchTerm" placeholder="Поиск...">
            <div class="search_list w-100">
                @if($users != null)
                <span>Пользователи</span>
                @foreach($users as $user)
                <a href="{{ route('profile',$user['id'] ) }}">
                    <span>{{$user['name']}}</span>
                    <span class="mobilePh">{{$user['mobile_phone']}}</span>
                    <span class="workPh">{{$user['work_phone']}}</span>
                </a>
                @endforeach
                @endif

                @if($posts != null)
                <span>Посты</span>
                @foreach($posts as $post)
                <a href="{{ route('showPost', ['categorySlug'=>$post['category']['slug'],'postSlug'=>$post['slug']]) }}">{{$post['title']}}</a>
                @endforeach
                @endif

            </div>
        </div>
    </div>
</div>

<style>
    .searchInput:focus+.search_list {
        display: flex;
    }

    .mobilePh {
        color: red;
    }

    .workPh {
        color: blue;
    }

    .search {
        display: block;
        width: 100%;

    }

    .search_list {
        display: none;
        flex-direction: column;
        position: absolute;
        margin-top: 1rem;

        background-color: #fff;
        border: 1px solid black;
        z-index: 1001;
    }

    .search_list:hover{
        display: flex;
    }
</style>