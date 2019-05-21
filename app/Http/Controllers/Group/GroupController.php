<?php /** @noinspection ALL */

namespace App\Http\Controllers\Group;

use App\Models\Group;
use App\Services\GroupService;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index()
    {


        return view('group.index');
    }

    public function store(Request $request)
    {

        $files = $request->file('thumbnail');

        if ($files) {
            // 副檔名
            $extension = $files->getClientOriginalExtension();
            // 檔案原始名稱
            $name = explode('.', $files->getClientOriginalName(), -1)[0];
            //修改名稱
            $name = 'thum.' . $extension;
            // 檔案上傳之前先寫 Group table
            $groupId = $this->group($request, $files, $name);
            // 建立檔案 檔名使用Group_id命名
            Storage::makeDirectory('public/group/' . $groupId);
            //圖片存擋
            Storage::putFileAs('public/group/' . $groupId, $files, $name);
            // 檔案路徑
        } else {
            $this->group($request);
        }


    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        $files   = $request->file('thumbnail');
        $groupId = $request->id;

        if ($files) {
            // 副檔名
            $extension = $files->getClientOriginalExtension();
            // 檔案原始名稱
            $name = explode('.', $files->getClientOriginalName(), -1)[0];
            //修改名稱
            $name = 'thum.' . $extension;
            // 檔案上傳之前先寫 Group table
            $this->updateGroup($request, $files, $name);
            // 建立檔案 檔名使用Group_id命名
            Storage::makeDirectory('public/group/' . $groupId);
            //圖片存擋
            Storage::putFileAs('public/group/' . $groupId, $files, $name);
        } else {
            $this->updateGroup($request);
        }


    }

    /**
     * @param Request $request
     * @param $files
     */
    private function group(Request $request, $files = null, $name = null)
    {
        $groupId = $this->groupService->create([
            'school_code' => $request->school_code,
            'name'        => $request->name,
            'description' => $request->description,
            'thumbnail'   => ($files) ? $name : '',
            'status'      => $request->public,
            'public'      => $request->status,
        ])->id;


        return $groupId;
    }

    /**
     * @param Request $request
     * @param $files
     * @param $name
     */
    private function updateGroup(Request $request, $files = null, $name = null)
    {
        $this->groupService->update($request->id, [
            'school_code' => $request->school_code,
            'name'        => $request->name,
            'description' => $request->description,
            'thumbnail'   => ($files) ? $name : '',
            'status'      => $request->public,
            'public'      => $request->status,
        ]);
    }

}
