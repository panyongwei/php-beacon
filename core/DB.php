<?php

namespace beacon;

/**
 * Created by PhpStorm.
 * User: wj008
 * Date: 2017/12/13
 * Time: 16:51
 */
class DB
{
    private static $engine = null;

    /**
     * 获取数据库引擎实例
     * @return Mysql|null
     * @throws MysqlException
     */
    public static function engine()
    {
        if (self::$engine != null) {
            return self::$engine;
        }
        $driver = Config::get('db.db_driver', 'Mysql');
        if ($driver == 'Mysql') {
            self::$engine = Mysql::instance();
            return self::$engine;
        }
        throw new \Exception('不支持的数据库驱动类型');
    }

    /**
     * 开启事务
     * @return bool
     * @throws MysqlException
     */
    public static function beginTransaction()
    {
        return self::engine()->beginTransaction();
    }

    /**
     * 事务闭包
     * @param $func
     * @throws \Exception
     */
    public static function transaction($func)
    {
        try {
            DB::beginTransaction();
            $func();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * 提交事务
     * @return bool
     * @throws MysqlException
     */
    public static function commit()
    {
        return self::engine()->commit();
    }

    /**
     * 回滚事务
     * @return bool
     * @throws MysqlException
     */
    public static function rollBack()
    {
        return self::engine()->rollBack();
    }

    /**
     * 执行sql 语句
     * @param string $sql
     * @return int
     * @throws MysqlException
     */
    public static function exec(string $sql)
    {
        return self::engine()->exec($sql);
    }

    /**
     * 获取最后一条sql 语句,需要开启 DEBUG_MYSQL_LOG
     * @return string
     * @throws MysqlException
     */
    public static function lastSql()
    {
        return self::engine()->lastSql();
    }

    /**
     * 获取最后的插入的id
     * @param null $name
     * @return string
     * @throws MysqlException
     */
    public static function lastInsertId($name = null)
    {
        return self::engine()->lastInsertId($name);
    }

    /**
     * 执行sql 语句
     * @param string $sql
     * @param null $args
     * @return bool|\PDOStatement
     * @throws MysqlException
     */
    public static function execute(string $sql, $args = null)
    {
        return self::engine()->execute($sql, $args);
    }

    /**
     * 获取多行记录
     * @param string $sql
     * @param null $args
     * @param null $fetch_style
     * @param null $fetch_argument
     * @param array|null $ctor_args
     * @return array
     * @throws \Exception
     */
    public static function getList(string $sql, $args = null, $fetch_style = null, $fetch_argument = null, array $ctor_args = null)
    {
        return self::engine()->getList($sql, $args, $fetch_style, $fetch_argument, $ctor_args);
    }

    /**
     * 获取单条数据
     * @param string $sql
     * @param null $args
     * @param null $fetch_style
     * @param null $cursor_orientation
     * @param int $cursor_offset
     * @return mixed|null
     * @throws \Exception
     */
    public static function getRow(string $sql, $args = null, $fetch_style = null, $cursor_orientation = null, $cursor_offset = 0)
    {
        return self::engine()->getRow($sql, $args, $fetch_style, $cursor_orientation, $cursor_offset);
    }

    /**
     * 获取单个字段值
     * @param string $sql
     * @param null $args
     * @param null $field
     * @return mixed|null
     * @throws \Exception
     */
    public static function getOne(string $sql, $args = null, $field = null)
    {
        return self::engine()->getOne($sql, $args, $field);
    }

    /**
     * 获取某个字段的最大值
     * @param string $tbname
     * @param string $field
     * @param null $where
     * @param null $args
     * @return null
     * @throws \Exception
     */
    public static function getMax(string $tbname, string $field, $where = null, $args = null)
    {
        return self::engine()->getMax($tbname, $field, $where, $args);
    }

    /**
     * 获取某个字段的最小值
     * @param string $tbname
     * @param string $field
     * @param null $where
     * @param null $args
     * @return null
     * @throws \Exception
     */
    public static function getMin(string $tbname, string $field, $where = null, $args = null)
    {
        return self::engine()->getMin($tbname, $field, $where, $args);
    }

    /**
     *  创建一个sql语句片段,一般用于更新 插入数据时数组的值
     * @param string $sql
     * @param null $args
     * @return SqlRaw
     * @throws MysqlException
     */
    public static function raw(string $sql, $args = null)
    {
        return self::engine()->raw($sql, $args);
    }

    /**
     * 插入记录
     * @param string $tbname
     * @param array $values
     * @throws MysqlException
     */
    public static function insert(string $tbname, array $values = [])
    {
        return self::engine()->insert($tbname, $values);
    }

    /**
     * 替换记录集
     * @param string $tbname
     * @param array $values
     * @throws MysqlException
     */
    public static function replace(string $tbname, array $values = [])
    {
        return self::engine()->replace($tbname, $values);
    }

    /**
     * 更新记录集
     * @param string $tbname
     * @param array $values
     * @param null $where
     * @param null $args
     * @throws MysqlException
     */
    public static function update(string $tbname, array $values, $where = null, $args = null)
    {
        return self::engine()->update($tbname, $values, $where, $args);
    }

    /**
     * 删除记录集
     * @param string $tbname
     * @param null $where
     * @param null $args
     * @throws MysqlException
     */
    public static function delete(string $tbname, $where = null, $args = null)
    {
        return self::engine()->delete($tbname, $where, $args);
    }

    /**
     * 获取表字段 判断字段是否存在
     * @param string $tbname
     * @return array
     * @throws \Exception
     */
    public static function getFields(string $tbname)
    {
        return self::engine()->getFields($tbname);
    }

    /**
     * 判断字段是否存在
     * @param string $tbname
     * @param string $field
     * @return bool
     * @throws \Exception
     */
    public static function existsField(string $tbname, string $field)
    {
        return self::engine()->existsField($tbname, $field);
    }

    /**
     * 创建数据库表
     * @param string $tbname
     * @param array $options
     * @throws MysqlException
     */
    public static function createTable(string $tbname, array $options = [])
    {
        return self::engine()->createTable($tbname, $options);
    }

    /**
     * 添加字段
     * @param string $tbname
     * @param string $field
     * @param array $options
     * @return int
     * @throws MysqlException
     */
    public static function addField(string $tbname, string $field, array $options = [])
    {
        return self::engine()->addField($tbname, $field, $options);
    }

    /**
     * 修改字段
     * @param string $tbname
     * @param string $field
     * @param array $options
     * @return int
     * @throws MysqlException
     */
    public static function modifyField(string $tbname, string $field, array $options = [])
    {
        return self::engine()->modifyField($tbname, $field, $options);
    }

    /**
     * 更新字段
     * @param string $tbname
     * @param string $oldfield
     * @param string $newfield
     * @param array $options
     * @return int
     * @throws MysqlException
     */
    public static function updateField(string $tbname, string $oldfield, string $newfield, array $options = [])
    {
        return self::engine()->updateField($tbname, $oldfield, $newfield, $options);
    }

    /**
     * 删除字段
     * @param string $tbname
     * @param string $field
     * @return int|null
     * @throws MysqlException
     */
    public static function dropField(string $tbname, string $field)
    {
        return self::engine()->dropField($tbname, $field);
    }

    /**
     * 检查表是否存在
     * @param string $tbname
     * @return bool
     * @throws \Exception
     */
    public static function existsTable(string $tbname)
    {
        return self::engine()->existsTable($tbname);
    }

    /**
     * 删除表
     * @param string $tbname
     * @return int
     * @throws MysqlException
     */
    public static function dropTable(string $tbname)
    {
        return self::engine()->dropTable($tbname);
    }
}
