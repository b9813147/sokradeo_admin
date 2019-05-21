<?php

namespace App\Http\Controllers\Channel;

use App\Services\GroupChannelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    protected $groupChannelService;

    public function __construct(GroupChannelService $groupChannelService)
    {
        $this->groupChannelService = $groupChannelService;
    }

    public function index()
    {

        return view('channel.index');
    }


    public function store(Request $request)
    {

        $files = $request->file('file');

        if ($files) {
            // 副檔名
            $extension = $files->getClientOriginalExtension();
            // 檔案原始名稱
            $name = explode('.', $files->getClientOriginalName(), -1)[0];
            //修改名稱
            $name = 'thum.' . $extension;
            // 檔案上傳之前先寫 Group table
            $channelId = $this->groupChannel($request, $files, $name);
            // 建立檔案 檔名使用Group_id命名
            \Storage::makeDirectory('public/group_channel/' . $channelId);
            //圖片存擋
            \Storage::putFileAs('public/group_channel/' . $channelId, $files, $name);
            // 檔案路徑
        } else {
            $this->groupChannel($request);
        }


    }


    /**
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {

        $files     = $request->file('file');
        $channelId = $request->id;

        if ($files) {
            // 副檔名
            $extension = $files->getClientOriginalExtension();
            // 檔案原始名稱
            $name = explode('.', $files->getClientOriginalName(), -1)[0];
            //修改名稱
            $name = 'thum.' . $extension;
            // 檔案上傳之前先寫 Group table
            $this->updateGroupChannel($request, $files, $name);
            // 建立檔案 檔名使用Group_id命名
            \Storage::makeDirectory('public/group_channel/' . $channelId);
            //圖片存擋
            \Storage::putFileAs('public/group_channel/' . $channelId, $files, $name);
        } else {
            $this->updateGroupChannel($request);
        }


    }

    /**
     * @param Request $request
     * @param $files
     * @param null $name
     * @return mixed
     */
    private function groupChannel(Request $request, $files = null, $name = null)
    {
        $channelId = $this->groupChannelService->create([
            'group_id'    => $request->group_id,
            'cms_type'    => $request->cms_type,
            'name'        => $request->name,
            'description' => $request->description,
            'thumbnail'   => ($files) ? $name : '',
            'status'      => $request->status,
            'public'      => $request->public,
        ])->id;


        return $channelId;
    }

    /**
     * @param Request $request
     * @param $files
     * @param $name
     */
    private function updateGroupChannel(Request $request, $files = null, $name = null)
    {
        $this->groupChannelService->update($request->id, [
            'group_id'    => $request->group_id,
            'cms_type'    => $request->cms_type,
            'name'        => $request->name,
            'description' => $request->description,
            'thumbnail'   => ($files) ? $name : '',
            'status'      => $request->status,
            'public'      => $request->public,
        ]);
    }
}
