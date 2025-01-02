<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanici Paneli')</title>
    @yield('links')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main.js'])
    <link rel="stylesheet" href="{{ asset('css/glocal.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="flex">
        <aside class="w-72 h-screen shadow bg-white text-gray-900">
            <nav class="flex flex-col h-full p-4">

                <a href="{{ route('kullanici.index') }}" class="flex items-center mb-8">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="size-8 me-3" alt="Flowbite Logo" />
                    <span class="text-2xl font-semibold whitespace-nowrap">uniportal</span>
                </a>

                <ul class="space-y-2">
                    @foreach ($menuler as $menu)
                        @if ($menu->bagli_menuler_id == null)
                            <li>
                                @if ($menu->altMenuler->count() > 0)
                                    <button type="button" @class([
                                        'flex items-center w-full py-1 px-3 rounded-lg transition hover:bg-gray-100 accordion-button',
                                    ])>
                                        <span class="p-1 rounded-lg me-2">
                                            {!! $menu->menuIcon !!}
                                        </span>
                                        <span>{{ $menu->menuAd }}</span>

                                        <svg class="size-2.5 ms-2.5 ml-auto" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>
                                    <ul class="hidden">
                                        @foreach ($menu->altMenuler as $altMenu)
                                            <li>
                                                <a href="{{ $altMenu->menuLink }}"
                                                    class="block indent-10 py-1 px-3 rounded-lg transition hover:bg-gray-100">{{ $altMenu->menuAd }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <a href="{{ $menu->menuLink }}" @class([
                                        'flex items-center py-1 px-3 rounded-lg transition',
                                        'bg-blue-700 text-white hover:text-white' => Request::is(
                                            ltrim($menu->menuLink, '/')),
                                        'hover:bg-gray-100' => !Request::is(ltrim($menu->menuLink, '/')),
                                    ])>
                                        <span class="p-1 rounded-lg me-2">
                                            {!! $menu->menuIcon !!}
                                        </span>
                                        <span>{{ $menu->menuAd }}</span>
                                    </a>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>

                <div class="mt-auto">
                    <a href="{{ route('kullanici.cikis') }}"
                        class="flex items-center py-2 px-3 rounded-lg hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 me-2">
                            <path fill-rule="evenodd"
                                d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Çıkış Yap</span>
                    </a>
                </div>
            </nav>
        </aside>

        <main class="p-4 w-full" style="min-height: 300vh">
            @yield('content')
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Explicabo maxime doloremque expedita porro repellat, amet possimus officia natus ut in voluptate facere minima minus? Nihil impedit atque voluptates minus! Aspernatur.
            Blanditiis saepe facilis corporis accusamus. Velit similique error, ullam ea itaque nisi ad consectetur facere, cum voluptate necessitatibus adipisci possimus porro voluptatum quae molestias sed aspernatur tenetur rem maiores eum.
            Modi expedita dolore fuga animi hic, cumque ullam velit deleniti esse saepe doloribus tempore, corrupti quasi sunt voluptate omnis corporis minus illo quidem placeat numquam eligendi sed? Unde, dolor quibusdam!
            Delectus consectetur eius aut qui odit iusto iure necessitatibus incidunt totam blanditiis aperiam quaerat, error dolor dolorum reiciendis. Nisi quae pariatur aperiam laudantium, officiis aut necessitatibus cumque minus molestiae delectus!
            Delectus doloremque consequuntur nisi commodi quisquam, a asperiores! Voluptatibus consectetur possimus dolorem, nesciunt aut explicabo id fugiat molestiae adipisci modi aliquam exercitationem rerum inventore, nulla necessitatibus corrupti repellendus repellat? Quibusdam?
            Odio dolore tempora harum temporibus accusamus corrupti. Porro asperiores veritatis necessitatibus atque? Soluta magni officia minus deserunt illum officiis amet eum cumque animi, accusantium quibusdam eveniet aut. Harum, dicta dignissimos?
            Veniam natus a velit aspernatur sequi facere obcaecati fugiat nesciunt doloribus quibusdam illo eligendi, voluptatibus eaque dignissimos et quam vitae. Dolorem debitis eum cupiditate molestiae quibusdam. Eos beatae quaerat ipsum.
            Repudiandae error adipisci quidem ipsa quos cum veritatis. Cupiditate voluptates asperiores dolor perspiciatis culpa beatae eligendi pariatur soluta sequi cum, ducimus possimus nisi expedita! Molestias beatae est assumenda accusamus quis.
            Possimus odit porro alias voluptate eum asperiores, fugiat quos cum et aspernatur at aut sint praesentium adipisci quibusdam quia nostrum laudantium ad. Consequatur veniam est dignissimos in excepturi maxime enim?
            Ea placeat numquam alias dolores odit necessitatibus, quia culpa quidem eveniet voluptatem repellat cumque eos dolorum, voluptates asperiores, impedit id quae. Officia, dolorum. Dolorum, pariatur iste! Quisquam adipisci commodi neque.
            Sit repellat, culpa, quibusdam quos incidunt delectus unde ratione sapiente accusamus molestias, fuga sequi praesentium rerum assumenda ad maiores facilis ex cum. Dignissimos placeat ad quos sed consectetur! Blanditiis, ipsam.
            Id voluptatibus quae, voluptate illum eos a itaque, veritatis aut soluta neque asperiores ducimus quam eaque distinctio. Ad ut, officiis possimus suscipit enim similique dolores dolore vitae at. In, quam?
            Possimus iure est ducimus. Dignissimos, ducimus eaque facere odit voluptas quibusdam veritatis! Consequuntur a, placeat ex, voluptatem distinctio aspernatur est, non nemo quidem consequatur animi et illo fuga sed voluptates.
            Laudantium accusantium ullam, hic labore numquam quaerat voluptatum repellendus inventore, dolore suscipit, quidem odit. Facilis voluptatem perspiciatis alias aliquid! Explicabo autem iusto repudiandae omnis, vitae cumque eveniet dignissimos magni esse.
            At doloribus quo repellat consequuntur non ipsa quas, blanditiis delectus harum voluptate suscipit molestias voluptatum recusandae eum fugiat quisquam temporibus, tempora placeat alias ducimus, veritatis corrupti aut ea animi. Dignissimos.
            Ea et fugiat blanditiis vel delectus quisquam ullam reiciendis culpa aliquam earum! Error nam tempore doloribus ipsam iusto. Consequuntur laboriosam quod nisi repudiandae quidem nobis voluptate, cupiditate explicabo natus expedita?
            Iure pariatur mollitia nesciunt omnis asperiores aliquid blanditiis, quidem expedita, explicabo maiores sit amet laudantium atque ut ea incidunt maxime quibusdam ipsum cupiditate ab ratione totam, tenetur minima accusantium. Consectetur.
            Dicta obcaecati eveniet incidunt nesciunt praesentium explicabo corporis fuga voluptate animi iste! Dolorum recusandae in nam placeat, eius error commodi quas iure minima quo tenetur quisquam culpa vel rem non.
            Error possimus unde suscipit atque incidunt ad quas adipisci pariatur quos hic, quo tempora molestias sequi soluta magnam quaerat accusantium. Non laborum aperiam ipsa est, nihil alias id repudiandae iste!
            Repellat doloribus recusandae earum. Itaque tempora hic vero nisi similique, quo quasi repellat recusandae quidem eius nulla consequuntur. Voluptas, voluptate vitae asperiores officiis illum ipsam minima adipisci ea cumque ipsa!
            Temporibus ullam repudiandae ipsum, unde officia rem, eligendi ab quis nostrum et quas? Delectus quod error nihil obcaecati, fugiat optio a dolorem cupiditate eaque repellendus aut veniam soluta suscipit rerum.
            Excepturi cumque quia quibusdam? Excepturi assumenda facilis libero recusandae fuga numquam, quaerat ullam quibusdam provident. Asperiores eum illo odit aperiam eveniet perspiciatis accusamus quisquam, quis voluptas maxime ipsam aliquid eius.
            Sapiente sequi temporibus ex minus id! Molestias sint at officia voluptates, nobis fuga tenetur culpa, adipisci veniam molestiae alias esse error! Nobis, dolor corrupti cum qui cupiditate voluptate exercitationem explicabo?
            Aspernatur libero possimus non minus natus sed suscipit. Enim aperiam necessitatibus blanditiis fuga numquam? Quibusdam sunt officiis, pariatur sint aperiam porro. In, porro similique? Totam doloribus alias sint tenetur mollitia!
            Sint labore autem sapiente, ipsum odio id nulla culpa enim adipisci hic animi porro pariatur quos mollitia? Reiciendis commodi ea deleniti laboriosam voluptas. Neque cum commodi eligendi officia tenetur alias!
            Minima sunt id pariatur! Autem expedita accusamus ad. Quaerat vitae animi porro voluptatem eum esse explicabo nostrum! Iure mollitia, illum earum aperiam quidem molestiae nam eos minus, corporis, ducimus sint!
            Pariatur atque quisquam, cupiditate optio perferendis autem quidem tempora magni nesciunt beatae distinctio. Enim est necessitatibus fuga excepturi eius ut ex ullam similique, nulla, labore error iste quis possimus facilis.
            Optio quam recusandae quos minus nam maiores inventore, adipisci, voluptatem repellat obcaecati impedit omnis aspernatur sunt reprehenderit nesciunt sit incidunt quidem perspiciatis? Harum eum enim ratione voluptatem recusandae commodi aperiam.
            Earum nobis officia fuga consequuntur beatae maiores molestias quos illum nesciunt provident fugit, cupiditate quam nam placeat necessitatibus minus. Sapiente quidem recusandae enim! Distinctio quisquam harum voluptas consequuntur nulla molestias.
            Dolorem dolorum laborum dolores esse. Ducimus necessitatibus sint repellendus vero placeat delectus laborum. Cum, rerum. Nostrum quasi veritatis totam rem dolore, placeat cum impedit ipsam provident? Nam odit ipsum iste!
            Necessitatibus iure rem numquam. Quo aperiam voluptate sunt adipisci labore unde distinctio architecto est consectetur dolore hic, totam nobis, quae dolorum incidunt obcaecati dicta minima illum dolor neque ad voluptates!
            Odit quidem ex iure pariatur commodi nesciunt, architecto expedita officia aspernatur tenetur repellendus eveniet? Numquam eum nostrum reprehenderit quod esse earum voluptatem quisquam, laboriosam nulla minus ipsa consequuntur ex laudantium.
            Deleniti vitae repellat sed aliquid vel numquam facilis, autem possimus laboriosam maxime! Quaerat consequatur, aspernatur cum illo voluptate dolor minima. Ut earum culpa omnis dolor, laborum quasi odit sequi beatae!
            Nisi maiores numquam eos ut id! Praesentium autem tenetur itaque beatae optio, asperiores distinctio voluptatum eius dignissimos inventore nihil accusantium, amet vitae sunt voluptatem a dolor eum numquam repellat cumque?
            Beatae unde accusantium atque, minima dolorem soluta, magni aperiam ad similique quam alias animi consectetur, dicta nihil? Expedita laboriosam non neque, esse voluptatibus quae reprehenderit eum, culpa deleniti quo totam!
            Rerum natus repellendus pariatur eius impedit voluptatum. Ad temporibus in nemo illum atque doloremque iusto perferendis odit. Eligendi dolor quam, asperiores hic sed iure ea vero labore, maiores, delectus beatae!
            Eveniet perspiciatis aliquid placeat excepturi, pariatur quidem. Voluptatum quisquam, maiores sapiente debitis saepe magni ullam sed iure! Itaque nesciunt ad ut illum aliquid et inventore earum qui vitae. Labore, excepturi?
            Architecto enim molestias fuga expedita dicta accusamus dolor debitis sit numquam quos laboriosam, dolorem aut voluptates illum reiciendis ducimus in. Sapiente incidunt sunt eum, libero natus voluptas amet vitae delectus?
            Reiciendis dignissimos provident quam corrupti assumenda minima mollitia quibusdam sit ullam unde illum, repellendus nesciunt. Iusto, sed ad? Eaque deserunt itaque obcaecati provident reprehenderit, ipsum adipisci nobis repellat nulla molestias.
            Voluptate culpa tempore magnam deleniti! Neque a tempora quo sed ad molestias voluptatibus placeat! Nihil voluptate repellendus fugit facere blanditiis iusto necessitatibus officia qui, soluta impedit, quos voluptatem, reprehenderit itaque.
            Accusamus esse iusto ipsa possimus, repudiandae qui, maxime a quidem optio quae maiores quibusdam! Consequatur ipsum vitae ad harum doloremque dignissimos debitis doloribus ab suscipit quidem. Libero iusto quia nam.
            Incidunt rerum maxime necessitatibus quo recusandae culpa numquam quae, ex assumenda alias et. Ducimus dolores quisquam quidem quis error iusto aut similique laudantium unde, ad odio eius, officiis sequi animi.
            Voluptatem amet itaque laboriosam saepe eaque, sequi officia neque rem qui doloribus quos magni delectus nulla explicabo ipsum, aut libero quia. Saepe, ad assumenda eius inventore commodi ex itaque. Animi.
            Est enim consectetur culpa eum, quaerat, omnis fugit dolor laboriosam modi quas soluta sed. Odit explicabo repellat animi consequatur corporis omnis laborum quis quibusdam, beatae itaque similique deleniti architecto. Repellat?
            Sed blanditiis nulla nobis necessitatibus pariatur eligendi, esse aperiam non totam praesentium voluptatibus labore. Possimus quas quisquam exercitationem! Aperiam, dolorem veniam accusamus harum obcaecati minima? Corporis quae perferendis nobis velit.
            Beatae praesentium dignissimos dolore, cupiditate totam impedit eligendi perspiciatis, laborum ratione fugit tempore, nemo architecto. Debitis, nulla recusandae harum rerum quaerat quis soluta, libero consequuntur, laboriosam dicta doloremque quos veritatis?
            Laborum neque suscipit debitis, facere quas alias eos maiores quis omnis repellat vero, a veritatis, labore ut aliquam culpa ratione quibusdam similique! Blanditiis doloremque fugiat tempora, earum sapiente omnis exercitationem?
            Delectus sed earum nihil voluptatibus ipsum atque eum, quae quam itaque similique iste quos sapiente architecto! Distinctio quisquam harum atque corporis cumque quam cupiditate debitis sed labore, sunt neque voluptas!
            At similique quas vitae nemo unde sit, beatae ex laudantium aspernatur qui repudiandae officia provident, harum ducimus perspiciatis facere veritatis nihil nobis odio consequatur quibusdam illo. Qui sit autem molestias!
            Quisquam eaque deserunt placeat soluta sed impedit debitis recusandae facere optio excepturi praesentium autem dolorem sunt ad pariatur voluptatem delectus vero, distinctio voluptatibus dolore vel dolor eveniet illo? Porro, voluptate.
            Necessitatibus omnis adipisci nulla, eum beatae laudantium, maxime ab ad quisquam nemo aspernatur repellendus laborum cum mollitia quas minus esse consequatur atque fuga! Quo, dolores repudiandae obcaecati nostrum facilis veniam?
            Optio sapiente ut consequatur facere, fugiat qui laboriosam aspernatur quia repudiandae facilis, iusto in pariatur error illum libero at ab voluptatem? Eum atque veritatis dolorum nihil reiciendis illo ipsam cupiditate.
            Deserunt ea veniam, quis ad tempora velit provident impedit blanditiis cum distinctio, atque harum, dolores officia fugiat necessitatibus exercitationem accusamus incidunt mollitia rem voluptate ipsa. Laudantium inventore sequi doloribus ipsam?
            Ad enim fuga perspiciatis doloremque reprehenderit. Doloribus ab explicabo commodi eligendi excepturi voluptates ut non! Assumenda laboriosam itaque maiores fugiat quas recusandae sed rem deserunt illo, aspernatur mollitia? A, voluptatum.
            Magnam inventore a quisquam sequi debitis, hic pariatur voluptas accusantium facere, consectetur quia cum, animi repudiandae rerum eos possimus vitae corrupti vero alias soluta repellendus? Rem ipsum harum blanditiis eius!
            Reiciendis suscipit repellat culpa voluptatibus, molestiae fugiat exercitationem tempore, voluptas harum impedit rerum qui vero earum assumenda omnis odit repudiandae repellendus laborum? Ex, aspernatur repellendus sequi harum incidunt ipsa dicta!
            Voluptatibus unde cupiditate sit quibusdam corrupti labore quis delectus, esse sequi iusto est rem. Nihil maiores repudiandae corrupti reiciendis eius. Quia inventore accusantium labore veniam quam at, quae corporis blanditiis.
            Ex sapiente in illum quas totam obcaecati. Neque consectetur quis repellendus necessitatibus aliquam architecto, doloribus ipsum vero nihil perferendis aliquid accusamus voluptate voluptates fuga iure provident eos error hic quibusdam.
            Quod voluptas impedit blanditiis quos suscipit, facilis, officiis illum saepe necessitatibus eaque harum aliquam odio? Quia molestias illo quisquam eius sint autem adipisci culpa voluptatibus nemo eligendi. Aliquid, eum fugiat?
            Cumque a cum eos reprehenderit provident qui excepturi repudiandae quaerat repellat corporis, eveniet quidem asperiores quisquam debitis recusandae autem explicabo quis dicta minus voluptatum itaque! Labore molestiae consequuntur enim ut.
            Dolore est pariatur et fugit, eum vel nulla quas inventore quam neque quaerat doloribus quasi, deserunt aliquam itaque ratione enim! Unde ullam reiciendis nobis expedita nulla ipsam tempore eveniet? Provident?
            Aut, saepe ipsam. Autem mollitia unde ut officia placeat maiores! Quod, placeat itaque! Necessitatibus quos optio nulla molestiae aliquid distinctio id maxime? Natus molestias amet odit mollitia laboriosam debitis odio.
            Itaque fugiat cumque earum eos non quos vel labore perferendis. Sed nisi mollitia, voluptates odit totam nesciunt praesentium voluptatibus laudantium vitae beatae at. Veritatis reiciendis eius cumque perspiciatis cupiditate impedit.
            Dolor atque odio quae possimus molestiae fugiat commodi perspiciatis qui veniam illo soluta earum quibusdam corrupti debitis ratione facere necessitatibus asperiores, blanditiis voluptatem? Architecto perspiciatis provident eligendi. Sapiente, ipsa consequuntur.
            Aliquam asperiores, veniam facilis id voluptate, illo natus consectetur totam eum ex impedit rem corrupti placeat deleniti repellat, laudantium quae fugit aliquid facere? Optio voluptate reprehenderit nam asperiores maxime! Natus!
            Non nulla provident velit ipsam distinctio nihil deserunt temporibus recusandae error, sunt vero totam expedita quia dolorem libero et! Sit inventore sunt, accusamus magnam molestias veritatis itaque temporibus quas aliquam?
            Dolor fugiat, perspiciatis quidem vitae, maiores molestias repudiandae quae cum beatae commodi veritatis aut at libero officiis nihil harum minima labore mollitia delectus provident! Eum rerum laborum doloremque aliquam consequatur.
            Dicta blanditiis saepe est deleniti quas odio quam eaque id placeat ullam, itaque distinctio, praesentium quibusdam. Facilis, dolorem assumenda, omnis consequatur quae minima dolore voluptatem, cum corporis reprehenderit officiis dolores!
            Doloremque maiores commodi aliquam harum quaerat dolorum earum. Odio eligendi dolorem voluptates, culpa ut laborum esse laudantium fuga ab porro at sed nulla iste sequi mollitia adipisci dicta maiores suscipit?
            Expedita ex error ducimus architecto ratione culpa iusto minima maiores quidem sit? Similique ipsum nemo dolores sunt non, cumque, architecto assumenda sequi maiores atque ducimus impedit officia minima consequuntur iusto.
            Iste, autem reiciendis, quibusdam necessitatibus, maxime ab magni doloribus asperiores nostrum expedita ipsum. Perspiciatis quae ipsa id pariatur quibusdam voluptates eveniet, veniam consequuntur nemo, at dicta officia. Cumque, iste optio.
            Sapiente culpa explicabo iste quos nostrum est nesciunt magni numquam delectus quia ullam quae, repellat vitae expedita optio fugit esse pariatur atque minima voluptate corrupti suscipit quibusdam blanditiis! Incidunt, id.
            Suscipit, veritatis. Vero modi veniam officiis eius tempora explicabo repellendus reiciendis velit facere temporibus ad, a asperiores error molestiae excepturi, non amet, debitis at voluptate ullam quisquam eaque. Nostrum, id.
            Facilis cum possimus et, itaque dolorem est quasi rem reprehenderit mollitia consequuntur maxime veniam. Ullam quo eaque doloribus sapiente, soluta quos magnam eos quis consequuntur, excepturi nam officiis assumenda minus.
            Quod aut cumque nobis numquam beatae libero voluptas quibusdam aliquid qui explicabo excepturi eum facilis, iste deserunt perferendis ipsam cum aspernatur. At corrupti amet, asperiores a quaerat dignissimos adipisci beatae.
            Ipsum officiis tempore ratione, modi accusantium odio, saepe deleniti dolorum perspiciatis non amet voluptas impedit? Maiores assumenda provident, praesentium explicabo, voluptate at quod blanditiis odio molestias, amet perferendis laboriosam corporis.
            Obcaecati veritatis est at, ipsa, tempore molestiae temporibus quaerat nobis, nulla perspiciatis reiciendis. Sapiente dolores quaerat ducimus repellat praesentium. Dolores, debitis ullam expedita excepturi nulla distinctio inventore officiis suscipit error.
            Consequuntur placeat, quae architecto et sunt nulla nesciunt provident distinctio explicabo totam, nemo labore. Rerum aspernatur reprehenderit necessitatibus, cumque ipsam voluptatibus quae explicabo dignissimos, expedita rem incidunt dolorem unde recusandae!
            Voluptatum provident vero voluptas tenetur odit, optio corrupti alias esse, quam dolorem eum cumque beatae enim, expedita veniam maxime. Laudantium eos, dolorum fuga earum nostrum quisquam minus officia sapiente ipsum?
            Asperiores odio eaque, ipsa deserunt nemo id. Dicta eos similique atque fugiat quo delectus provident quam perspiciatis libero labore ab, explicabo quaerat modi expedita cumque amet, voluptatem impedit eius officia.
            Aspernatur amet molestias iure sint sit, sed harum necessitatibus, et laudantium nihil illum, fugiat laboriosam? Voluptatibus unde blanditiis laborum numquam voluptatum, possimus aperiam praesentium repellendus, fugiat nulla aliquam mollitia amet.
            Labore blanditiis voluptatum modi mollitia. Ab soluta, modi nisi quae dignissimos fugiat totam velit ipsum vel animi, quia deserunt molestiae praesentium rem eligendi repellat. Quos quo voluptates accusamus sequi quia!
            Error accusantium reprehenderit corporis blanditiis, ducimus, sequi, exercitationem temporibus labore aperiam illo unde! Harum tempore quibusdam possimus esse voluptas quasi debitis aliquid dolore culpa maxime, similique excepturi unde velit perferendis.
            Autem, quas? Ut est sit dolore? Praesentium accusamus laboriosam beatae excepturi dolorum minus amet numquam maxime eligendi saepe ab est molestias, omnis nesciunt exercitationem enim voluptatem officiis minima cumque doloribus.
            Laboriosam, doloremque impedit temporibus veritatis commodi pariatur at consequatur aperiam eveniet dolore id delectus placeat! Cum praesentium neque dolor quo quaerat est suscipit quas vitae, ipsam culpa vero, architecto quae.
            Ipsum itaque veritatis non numquam fugiat consectetur. Officiis, aperiam quis earum quia fugiat laudantium! Officia maxime voluptatibus animi molestiae ducimus vitae rerum? Sint porro sapiente doloremque repellat repudiandae? Nobis, unde.
            Distinctio odit, magnam fuga, rem atque hic culpa sint accusamus, laboriosam quasi nisi aliquid alias omnis dicta explicabo eius nostrum ipsam praesentium iusto repellat modi quos assumenda minima. Atque, iste.
            Porro, rerum ut veritatis quam dolore commodi impedit suscipit sequi aut veniam praesentium libero eos sint ipsum quae, cumque ex cum reiciendis repudiandae consequatur. Consectetur tenetur voluptatum ut cumque. Architecto.
            Voluptatem provident culpa quis, dolorum quaerat porro possimus quasi impedit exercitationem alias rem voluptates temporibus illo distinctio, ea autem. Pariatur consequuntur deserunt commodi asperiores animi enim quasi quisquam laboriosam reprehenderit.
            Esse iste repellendus ab, deserunt aliquid earum, sapiente excepturi fuga saepe quasi odit eligendi aut numquam voluptas neque voluptatum cupiditate tempora! Aliquid quae consequuntur, blanditiis vero at iusto? Distinctio, aliquid?
            Est, placeat ab temporibus quaerat voluptate quisquam laudantium, ea magni velit earum dolores non numquam omnis ut dolore, dolor officia assumenda perspiciatis quos! Consequuntur recusandae maxime quas. Ipsum, numquam mollitia.
            Reprehenderit officiis laudantium id, consequatur omnis consequuntur assumenda temporibus sed totam, cupiditate repellat minus, laboriosam exercitationem odio voluptatibus quidem nostrum quibusdam doloribus ducimus labore harum dicta corrupti. Dolorem, corporis similique.
            Eius mollitia minus quasi quisquam accusantium odio rem asperiores, illo incidunt ab quas. Vitae dolores ipsa facilis iusto, praesentium at non, animi eius porro, voluptatum distinctio rerum maiores neque et?
            Asperiores incidunt ad ullam qui fugit eligendi excepturi deserunt consectetur itaque non voluptates, architecto quas nostrum ex unde tempora quis eius rerum eaque, repellendus similique iure dolores harum? Maiores, pariatur.
            Deleniti facilis maxime molestiae veniam voluptas ratione est magni quo earum error delectus, itaque corporis! Esse repellendus ad error nam natus, hic consequatur enim, nulla qui ex nemo sunt earum.
            Perferendis enim eos delectus id odit laudantium eius, quibusdam ea est necessitatibus omnis aperiam distinctio nostrum quisquam veritatis aut dolor asperiores voluptatem temporibus vel sit, ab tempore voluptates tempora. Qui?
            Et exercitationem placeat optio, mollitia quia labore quod tempore id aspernatur consectetur corrupti quasi sint numquam inventore obcaecati minima delectus consequatur corporis sunt. Sequi dolorem, provident debitis molestias vel magnam.
            In, beatae. Placeat vel provident accusamus repellendus quaerat. Enim atque incidunt iure rem mollitia, molestiae dignissimos autem tempora facere reprehenderit libero eius obcaecati vero reiciendis deserunt, quidem illo provident est!
            Suscipit asperiores officiis consequatur ab pariatur. Eveniet sequi accusantium laudantium deleniti minima tempora exercitationem quos beatae ipsum! Quis magni dolores quasi, delectus corrupti obcaecati, animi et ea quod dolorum voluptatem.
            Non, cumque eveniet tempora illum sunt omnis neque, quia at asperiores vero accusamus, ratione nesciunt. Eius voluptates minus molestiae nesciunt qui. Nulla earum veniam perferendis consectetur maiores vero corrupti enim!
        </main>

        <div id="alerts" class="absolute right-4 bottom-4 z-30 space-y-2"></div>
    </div>

    @yield('scripts')
    <script>
        window.App = {
            baseUrl: "{{ url('/') }}"
        };
    </script>
</body>

</html>
