namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class EstabelecimentosTable extends Component
{
    use WithPagination;

    // ...existing code...

    public function render()
    {
        $estabelecimentos = Estabelecimento::paginate(10);

        return view('livewire.estabelecimentos-table', [
            'estabelecimentos' => $estabelecimentos,
        ]);
    }
}
