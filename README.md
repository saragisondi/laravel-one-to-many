PORTFOLIO
=======

## 1)

### **Descrizione**:
Iniziare a creare il progetto usando laravel breeze ed il pacchetto Laravel 9 Preset con autenticazione, separando gli ambienti Guest da quelli Admin per quanto riguarda stili, js, controller, viste e layout.

### **Steps:**
 *Creazione del progetto:*
- Creo il progetto: `composer create-project --prefer-dist laravel/laravel:^9.2 laravel_auth`

- Utilizzo il composer: `composer require laravel/breeze --dev`

- Installo breeze: `php artisan breeze:install `

- Aggiungo il pacchetto Pacifici: `composer require pacificdev/laravel_9_preset`

- Aggiungo Bootstrap: `php artisan preset:ui bootstrap --auth`

- Installo Vue: `npm i`

- Creo un nuovo DB in *php MyAdmin*

- Nel file *.env* inserisco il nome del DB e controlle che le credenziali siano corrette

- Lancio i server: `npm run dev` e `php artisan serve`

<br>

 *Separazione degli ambienti:*

- Creo il *PageController* che mi restituisce la vista della *home* visibile all'utente: `php artisan make: controller Guest/PageController` 

- Collego la rotta della *home* al *PageController*

- Creo *appGuest* in scss e in js, li aggiungo in *vit.config.js* e modifico lo *script* in *guest.blade.php* 

- Creo il *DashbordController* che mi restituisce la vista della *admin.home*:  `php artisan make:controller Admin/DashbordController`

- Modifico `public const HOME = '/admin'` in  *RouteServiceProvider* poi in *web* raggruppo tutte le rotte che hanno: <br>
  - il *middleware(['auth', 'verified'])* che hanno <br>
  - il *name* che inizia con *admin.* <br>
  - il *prefisso* che inzia con *admin* <br>

  Faccio una funzione di callback per raggrupparle:
   
   - Collego la rotta della *home* al *DashbordController* : <br>
   `->group(function(){` 

        `Route::get('/', [DashbordController::class, 'index'])->name('home');` <br>
   `}`

<br>

## 2)

### **Descrizione**:
Creare la CRUD del Portfolio.
Immaginare quali dati servono per un portfolio e quindi generare la migration.
Il seeder è opzionale, l’importante che tutta la CRUD funzioni correttamente con tutte le funzionalità viste.

**BONUS:** in *edit* e *create* sostituire la textarea con un CK Editor.

<br>

### **Steps:**

*Layout:*
- Creo una navbar con il link che mi porta alla *Home*

- Creo un aside con i link che mi portano:

  - *Dashbord*
  - *Lista Progetti*
  - *Creazione di un nuovo progetto*

*Migration:*

- Creo il model e la migration: `php artisan make:model Project -m`

- Creo i records della tabella *Projects*

- Lancio la migration: `php artisan migrate`

*Seeder:*

- Creo il seeder: `php artisan make:seeder ProjectsTableSeeder`

- Importo il *Models\Project* e il *Faker\Generator*

- Utilizzo il *Faker* per popolare il DB

- Faccio una funzione per creare lo *Slug* dentro il *Models\Project*: <br>

  `public static function generateSlug($str){` <br>
        `$slug = Str::slug($str, '-');` <br>
        `$original_slug = $slug;` <br>
        `$slug_exists = Project::where('slug', $slug)->first();` <br>
        `$c = 1;` <br>
        `while($slug_exists){` <br>
            `$slug = $original_slug . '-' . $c;` <br>
            `$slug_exists = Project::where('slug', $slug)->first();` <br>
            `$c++;` <br>
        `}` <br>
        `return $slug;` <br>
      `}` <br>

<br>

- Richiamo lo *Slug* dentro la funzione del *Faker*:
`$new_project -> slug = Project::generateSlug($new_project->title);`

- Lancio il seeder: `php artisan db:seed --class=ProjectsTableSeeder`
<br>
<br>

- Nelle *view* creo una cartella *Projects* dove andrò a mettere:

  - *Index*
  - *Home*
  - *Show*
  - *Create*
  - *Edit*
  - *Delete*

<br>

###  **Index:**
- Creo il *ProjectController* e dentro la *function index* 
  - Faccio una query per vedere tutti i dati 
  - Creo il paginator: ` $projects = Project::paginate(10);`
  - Includo il paginator in *AppServiceProvider:* `use Illuminate\Pagination\Paginator;` <br>
  Nella funzione boot inserisco: `Paginator::useBootstrap();` <br>
  In *index.blade.php* inserisco: `$post->links()`
  - Metto la vista della *index* nel return
  
<br>

- Faccio un *foreach* dentro *index.blade.php* per stamparli in pagina

- Creo i link e le rotte per:
  - *Show* 
  - *Edit* 
  - *Delete*

<br>

- Aggiungo la rotta alla funzione di callback in *web*:
    `Route::resource('projects', ProjectController::class);`
    
    <br>

- Nell'**aside** collego l'*href* del link:
  - *Dashbord* nella navbar alla rotta *home*
  - *Projects* nella navbar alla rotta *index*
  - *New Project* nella navbar alla rotta *create*

  <br>

###  **Home:**

  - Inserisco l'ultimo progetto e il numero dei progetti creati
  
  - Nella funzione *index* del *DashbordController*:
    `$n_project = Project::all()->count();`
    `$last_project = Project::orderby('id', 'desc')->first();`

<br>

 ###  **Show:**

  - Formatto la data: <br> 
  `$date = date_create($project->date);` <br> 
  `$date_formatted = date_format($date, 'd/m/Y' );`

  - Nel return inserisco la vista *show* , il *project* e *date_formatted*


<br>

###  **Create:**

- Nel return inserisco la vista *create*

- In *create.blade.php*:
    - Faccio un form con la rotta che punta allo *store* 
    - Inserisco tutti i campi della migration
    - Inserisco il *CK Editor:* <br>
      `<script>`<br>
  `ClassicEditor`<br>
      `.create( document.querySelector( '#text' ) )`<br>
      `.catch( error => {`<br>
         ` console.error( error );`<br>
      `} );`<br>
`</script>`


<br>


### **Store:**

- Salvo il dato che ricevo:<br>
 `$form_data = $request->all();`

- Creo lo slug: <br>
  `$form_data['slug'] = Project::generateSlug($form_data['title']);`
  `$form_data['date'] = date('Y-m-d');`

- Creo una nuova istanza: <br>
  `$new_project = new Project();`

- Passo gli elementi al *controller* tramite il *fillable*:
  `$new_project ->fill($form_data);`

- Salvo:
  `$new_project->save();`

- Inserisco nel *return* il *redirect* della route *show*

- All'interno del *Models* faccio un array *protected Fillable*: <br>

  `protected $fillable = [`<br>
        `'title',`<br>
        `'slug',`<br>
        `'text',`<br>
        `'date',`<br>
        `'reading_time',`<br>
        `'image_path',`<br>
        `'image_original_name'`<br>
      `];`

 **Validazione:**
  - Creo una *Request*: `php artisan make:request ProjectRequest`

  - Modifico il return in *true* nella funzione *authorize*

  - Inserisco le regole nel return della funzione *rules*

  - Creo una funzione *messages* per inserire i messaggi che verranno stampati in pagina in caso di errore

  - Nella funzione *store* in *ProjectController* gli passo il parametro *ProjectRequest*

- Inserisco la condizione di errore nel file *create.blade.php*:

`@if($errors->any())`<br>
  `<div class="alert alert-danger" role="alert">`<br>
    `<ul>`<br>
      `@foreach ($errors->all() as $error)`<br>
      `<li>{{$error}}</li>`<br>
      `@endforeach`<br>
    `</ul>`<br>
  `</div>`<br>
  `@endif`<br>

  - Inserisco i messaggi  per visualizzarli in pagina
  
  <br>

###  **Edit:**

- Nel return inserisco la vista *edit*

- In *edit.blade.php*:
    - Faccio un form con la rotta che punta al *update* e oltre al metodo *POST* aggiungo il `@method('PUT')`
    - Inserisco tutti i campi della migration
    - Inserisco il *CK Editor* <br>

<br>

###  **Update:**

- Passo i paramentri: `ProjectRequest $request,Project $project`

- Salvo il dato che ricevo: <br>
  `$form_data=$request->all();`
  `$project->update($form_data);`
  
- Nel return inserisco il *redirect* alla rotta *show*

<br>

###  **Delete:**

- Nel return inserisco il redirect alla rotta *index* con la chiave *deleted* e nel valore inserisco il messaggio di eliminazione

- Nel file *index.blade.php* faccio un form con *action* la rotta *destroy* e oltre al metodo *POST* aggiungo anche il `@method('DELETE')`

- Creo il bottone 'elimina'

<br>

<br>

## 3)

### **Descrizione**:
Completare la CRUD del portfolio con l’aggiunta dell’immagine e la sua relativa eliminazione.

<br>

### **Steps:**

- Imposto il *FYLESYSTEM* in public

- Faccio diventare pubblica la cartella *storage* creandone un symlink:
`php artisan storage:link`

- Aggiungo al form del file *create.blade.php* `enctype="multipart/form-data"` 

- Aggiungo il file dell'upload dell'immagine nella input

- Faccio l'update della tabella per aggiornare il DB con i campi *path_image* e *original_image*:
`php artisan:make migration update_projects_table --table=projects`

- Nella funzione *up* inserisco le colonne da aggiungere e nella funzione *down* faccio il *dropColumn*

- Faccio `php artisan migrate` per vederle nel DB

- Aggiungo i due campi nel *fillable* 

- Importo lo *Storage* in *ProjectController*:
`use Illuminate\Support\Facades\Storage;`

- Nella funzione *store* verifico se è stata caricata un'immagine, salvo il nome dell'immagine, salvo l'immagine nella cartella *uploads* e il percorso:

  `if(array_key_exists('image',$form_data)){` <br>

    `$form_data['image_original_name'] = $request->file('image')->getClientOriginalName();` <br>

    `$form_data['image_path'] = Storage::put('uploads',` `$form_data['image']);` <br>
        `}`

- In *show.blade.php* inserisco `{{asset('storage/' . $project->image_path)}}` per visualizzare l'immagine

- In *create.blade.php* faccio l'anteprima dell'immagine attraverso la funzione *showImage* e la invoco nel campo di input dell'immagine con *onchange*:<br>
      `function showImage(event){`<br>
          `const tagImage = document.getElementById('prev-image');`<br>
          `tagImage.src = URL.createObjectURL(event.target.files[0]);`<br>
        `}`

- In *ProjectController* nella funzione *edit* oltre a verificare se è stata caricata l'immagine inserisco la condizione per cui se ne carico una nuova viene eliminata la vecchia:

  `if($project->image){` <br>
            `Storage::disk('public')->delete($project->image_path);` <br>
          `}`

- In *ProjectController* nella funzione *destroy* inserisco la condizione che se il progetto da eliminare contiene un'immagine, la devo cancellare:

  `if($project->image){` <br>
            `Storage::disk('public')->delete($project->image_path);` <br>
          `}`


## 4)
### **Descrizione**:
Aggiungere una nuova entità **Type**. <br>
Questa entità rappresenta la tipologia di progetto ed è in relazione **one to many** con i progetti. <br>
I task da svolgere sono diversi, ma alcuni di essi sono un ripasso di ciò che abbiamo fatto nelle lezioni dei giorni scorsi:
- creare la migration per la tabella `types`
- creare il model `Type`
- creare la migration di modifica per la tabella `projects` per aggiungere la chiave esterna
- aggiungere ai model Type e Project i metodi per definire la relazione one to many
- visualizzare nella pagina di dettaglio di un progetto la tipologia associata, se presente
- permettere all’utente di associare una tipologia nella pagina di creazione e modifica di un progetto
- gestire il salvataggio dell’associazione progetto-tipologia con opportune regole di validazione <br>
**Bonus 1:**
creare il seeder per il model Type e il seeder della tabella ‘projects’ con l’id del type (random) in relazione <br>
**Bonus 2:**
aggiungere le operazioni CRUD per il model Type, in modo da gestire le tipologie di progetto direttamente dal pannello di amministrazione.
### **Steps:**
**Migration**
- Faccio la migration della tabella *type*
- Lancio la migration
**Seeder**
- Creo il seeder:
  - Creo un array
  - Ciclo gli elementi
<br>
- Lancio il seeder
- Creo una migration update:
`php artisan make:migration update_projects_table --table=projects`
**Foreign Key: type**
- Nella function *up*:
  - Creo la colonna della *Foreign Key*: `$table->unsignedBigInteger('type_id')->nullable()->after('id')`
  - Assegno la *Foreign Key* alla colonna creata: <br>
  `$table->foreign('type_id')` <br>
         `->references('id')` <br>
          `->on('types')` <br>
          `->onDelete('set null');` <br>
          
- Nella function *down*:
  - Elimino la *Foreign key*: `$table->dropForeign(['type_id']);`
  - Elimino la colonna: `$table->dropColumn('type_id');`
**One to Many**
- Nel *Model\Project* faccio una funzione per mettere *Project* in relazione la tabella *Type*:<br>
 `public function type(){`<br>
    `return $this->belongsTo(Type::class);`<br>
    `}`
- Nel *Model\Type* faccio una funzione per mettere *Type* in relazione la tabella *Project*:<br>
`public function projects(){`<br>
    `return $this->hasMany(Projects::class);`<br>
    `}`
