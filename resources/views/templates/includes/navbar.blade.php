<nav>
    <div class="width-1200">
        <div class="left">
            <a href="{{route('home')}}" class="container-logo">
                <img src="{{asset('img/menu-logo.png')}}" class="logo" />
            </a>
        </div>
        <form class="middle">
            <input type="search" id="input-search" placeholder="Rechercher ..." />
            <div class="search-result" id="search-result">
                <ul>
                    <li class="bold">
                        <a>Entreprises</a>
                    </li>
                    <li class="bold">
                        <a>Communautés</a>
                    </li>
                    <li class="bold">
                        <a>Catégories</a>
                    </li>
                </ul>
            </div>
        </form>
        <div class="right">
            <a href="{{route('login')}}" class="button-linkedin" type="button"></a>
        </div>
    </div>
</nav>