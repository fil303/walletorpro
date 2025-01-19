@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('SMS Setting'))

@section('head')

    <style>
        /* Custom hover effect for the cards */
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
    </style>

@endsection

@section('content')
    <!-- Theme Setting Card -->
    <div class="card-body">
        <div class="flex justify-between">
            <h2 class="card-title text-2xl font-bold text-center">Theme Settings</h2>
            <a href="{{ route('settingPage') }}" class="btn">
                <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M9 14 4 9l5-5" />
                    <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                </svg>
                {{ __("Button") }}
            </a>
        </div>

        <!-- Pre-built Theme Cards -->
        <div class="grid sm:block md:grid-cols-2 grid-cols-3 gap-4 mt-6">
            <!-- Theme Cards -->
            <div class="card shadow-md cursor-pointer" onclick="setTheme('light')" data-theme="light">
                @if(($app->theme ?? '') == 'light')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Light</h3>
                    <p>Clean, bright theme</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('dark')" data-theme="dark">
                @if(($app->theme ?? '') == 'dark')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Dark</h3>
                    <p>Classic dark mode</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('cupcake')" data-theme="cupcake">
                @if(($app->theme ?? '') == 'cupcake')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Cupcake</h3>
                    <p>Soft pastel shades</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('bumblebee')" data-theme="bumblebee">
                @if(($app->theme ?? '') == 'bumblebee')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Bumblebee</h3>
                    <p>Bright, sunny colors</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('emerald')" data-theme="emerald">
                @if(($app->theme ?? '') == 'emerald')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Emerald</h3>
                    <p>Fresh, nature-inspired</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('corporate')" data-theme="corporate">
                @if(($app->theme ?? '') == 'corporate')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Corporate</h3>
                    <p>Professional and clean</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('synthwave')" data-theme="synthwave">
                @if(($app->theme ?? '') == 'synthwave')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Synthwave</h3>
                    <p>Neon and retro</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('retro')" data-theme="retro">
                @if(($app->theme ?? '') == 'retro')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Retro</h3>
                    <p>Vintage style</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('cyberpunk')" data-theme="cyberpunk">
                @if(($app->theme ?? '') == 'cyberpunk')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Cyberpunk</h3>
                    <p>Bold and neon</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('valentine')" data-theme="valentine">
                @if(($app->theme ?? '') == 'valentine')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Valentine</h3>
                    <p>Romantic, soft shades</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('halloween')" data-theme="halloween">
                @if(($app->theme ?? '') == 'halloween')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Halloween</h3>
                    <p>Spooky and dark</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('garden')" data-theme="garden">
                @if(($app->theme ?? '') == 'garden')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Garden</h3>
                    <p>Floral and fresh</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('forest')" data-theme="forest">
                @if(($app->theme ?? '') == 'forest')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Forest</h3>
                    <p>Dark, nature-inspired</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('aqua')" data-theme="aqua">
                @if(($app->theme ?? '') == 'aqua')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Aqua</h3>
                    <p>Cool, water-inspired</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('lofi')" data-theme="lofi">
                @if(($app->theme ?? '') == 'lofi')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Lofi</h3>
                    <p>Low-fidelity style</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('pastel')" data-theme="pastel">
                @if(($app->theme ?? '') == 'pastel')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Pastel</h3>
                    <p>Soft pastel colors</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('fantasy')" data-theme="fantasy">
                @if(($app->theme ?? '') == 'fantasy')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Fantasy</h3>
                    <p>Colorful and dreamy</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('wireframe')" data-theme="wireframe">
                @if(($app->theme ?? '') == 'wireframe')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Wireframe</h3>
                    <p>Minimal and outline-based</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('black')" data-theme="black">
                @if(($app->theme ?? '') == 'black')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Black</h3>
                    <p>Bold, high-contrast</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('luxury')" data-theme="luxury">
                @if(($app->theme ?? '') == 'luxury')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Luxury</h3>
                    <p>High-end, elegant</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('dracula')" data-theme="dracula">
                @if(($app->theme ?? '') == 'dracula')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Dracula</h3>
                    <p>Dark, blood-red theme</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('autumn')" data-theme="autumn">
                @if(($app->theme ?? '') == 'autumn')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Autumn</h3>
                    <p>Warm autumn colors</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('business')" data-theme="business">
                @if(($app->theme ?? '') == 'business')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Business</h3>
                    <p>Professional and minimal</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('acid')" data-theme="acid">
                @if(($app->theme ?? '') == 'acid')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Acid</h3>
                    <p>Bright neon colors</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('lemonade')" data-theme="lemonade">
                @if(($app->theme ?? '') == 'lemonade')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Lemonade</h3>
                    <p>Fresh and zesty</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('night')" data-theme="night">
                @if(($app->theme ?? '') == 'night')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Night</h3>
                    <p>Dark with cool tones</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('coffee')" data-theme="coffee">
                @if(($app->theme ?? '') == 'coffee')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Coffee</h3>
                    <p>Warm coffee shades</p>
                </div>
            </div>

            <div class="card shadow-md cursor-pointer" onclick="setTheme('winter')" data-theme="winter">
                @if(($app->theme ?? '') == 'winter')
                    <p class="badge badge-primary p-2">{{ __('Active') }}</p>
                @endif
                <div class="card-body text-center">
                    <h3 class="font-bold">Winter</h3>
                    <p>Cool, icy colors</p>
                </div>
            </div>

        </div>

        @if (false)
            <!-- Custom Theme Section -->
            <div class="divider">OR</div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Generate Your Own Theme (DaisyUI Theme Generator)</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <input name="primary" value="{{ $app->primary ?? '' }}" type="text"
                        placeholder="Primary Color (e.g. #FF5733)" id="primaryColor" class="input input-bordered" />
                    <input name="secondary" value="{{ $app->secondary ?? '' }}" type="text"
                        placeholder="Secondary Color (e.g. #33FF57)" id="secondaryColor" class="input input-bordered" />
                    <input name="accent" value="{{ $app->accent ?? '' }}" type="text"
                        placeholder="Accent Color (e.g. #5733FF)" id="accentColor" class="input input-bordered" />
                    <input name="neutral" value="{{ $app->neutral ?? '' }}" type="text"
                        placeholder="Neutral Color (e.g. #333333)" id="neutralColor" class="input input-bordered" />
                </div>
                <button class="btn btn-primary mt-4" onclick="applyCustomTheme()">Apply Custom Theme</button>
            </div>

            <!-- Test Theme Button -->
            <div class="form-control mt-6">
                <button class="btn btn-success w-full" onclick="testTheme()">Test Theme Settings</button>
            </div>
        @endif
    </div>




@endsection
@section('downjs')

    <script>
        // Function to set pre-built theme
        function setTheme(theme) {
            updateTheme(theme, "pre-build");
        }

        // Function to apply custom theme
        function applyCustomTheme() {
            updateTheme("", "custom");
        }

        // Function to test the theme
        function testTheme() {
            const primary = document.getElementById('primaryColor').value;
            const secondary = document.getElementById('secondaryColor').value;
            const accent = document.getElementById('accentColor').value;
            const neutral = document.getElementById('neutralColor').value;

            const customTheme = {
                '--color-primary': primary,
                '--color-secondary': secondary,
                '--color-accent': accent,
                '--color-neutral': neutral,
            };

            // Apply custom theme
            for (const key in customTheme) {
                if (customTheme[key]) {
                    document.documentElement.style.setProperty(key, customTheme[key]);
                }
            }
        }

        function updateTheme(theme = "", type = "pre-build") {
            let url = '{{ route('themeSettingSave') }}';
            let sendData = {
                "_token": "{{ csrf_token() }}",
                "type": type,
                "theme": theme,
                // "primary": document.getElementById('primaryColor').value,
                // "secondary": document.getElementById('secondaryColor').value,
                // "accent": document.getElementById('accentColor').value,
                // "neutral": document.getElementById('neutralColor').value,
            }

            $.post(url, sendData, (response) => {
                if (response.status) {
                    document.documentElement.setAttribute('data-theme', theme);
                    console.log("response", response);
                    Notiflix.Notify.success(response.message);
                    return;
                }
                console.log("response", response);
                Notiflix.Notify.failure(response.message || '{{ __("Theme update failed") }}');
            });

        }
    </script>

@endsection
