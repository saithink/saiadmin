<?php

namespace plugin\saiadmin\service;

/**
 * 权限注解
 */
#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_CLASS)]
class Permission
{
    /**
     * 权限标题/名称
     */
    public string $title;

    /**
     * 权限标识（唯一，格式如：module:controller:action）
     */
    public ?string $slug = null;

    /**
     * 构造函数 #[Permission(title:'标题', slug:'标识')]
     * @param string|null $title
     * @param string|null $slug
     */
    public function __construct(
        ?string $title = null,
        ?string $slug = null,
    )
    {
        $this->title = $title ?? '';
        $this->slug = $slug;
    }

    /**
     * 获取权限标题
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * 获取权限标识
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

}
